import React, { useState, useEffect, useRef } from 'react';
import {useLocation, useNavigate} from 'react-router-dom';
import Pusher from 'pusher-js';
import {toast} from "react-toastify";

const ChatCanvas = () => {
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);
    const [messages, setMessages] = useState([]);
    const [message, setNewMessage] = useState('');
    const [chatId, setChatId] = useState(null); // State for chatId
    const messagesEndRef = useRef(null);
    const location = useLocation();
    const specialistName = location.state?.specialistName || 'Specialist';
    const specialistRoute = location.state?.specialistRoute || 'default-route';
    const userId = localStorage.getItem('userId'); // Cache userId
    const navigate = useNavigate();

    // Check for auth token on component mount
    useEffect(() => {
        const authToken = localStorage.getItem('authToken');
        if (!authToken) {
            toast.error('Login first!', {
                position: 'top-right',
                autoClose: 3000,
                hideProgressBar: false,
                closeOnClick: true,
                pauseOnHover: true,
                draggable: true,
            });
            navigate('/Login'); // Redirect to login page
        }
    }, [navigate]);
    useEffect(() => {
        scrollToBottom();
    }, [messages]);

    const scrollToBottom = () => {
        requestAnimationFrame(() => {
            messagesEndRef.current?.scrollIntoView({ behavior: 'smooth' });
        });
    };

    const fetchChat = async () => {
        try {
            setLoading(true);
            setError(null);

            const response = await fetch(`http://127.0.0.1:8000/api/chat/${specialistRoute}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${localStorage.getItem('authToken')}`,
                },
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();
            setChatId(data.chat.id); // Store chatId in state
            localStorage.setItem('chatId', data.chat.id); // Persist to localStorage
            setMessages(data.messages || []);
        } catch (err) {
            setError(err.message);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        const authToken = localStorage.getItem('authToken');
        if (authToken && specialistRoute) {
            localStorage.removeItem('chatId'); // Clear any stale chatId
            setChatId(null); // Reset chatId state
            fetchChat();
        }
    }, [specialistRoute]);

    // Cleanup chatId on unmount
    useEffect(() => {
        return () => {
            localStorage.removeItem('chatId');
            setChatId(null);
        };
    }, []);

    // Pusher integration
    useEffect(() => {
        if (!chatId) return;

        const pusher = new Pusher('4c87306082ee4de377c5', {
            cluster: 'ap2',
        });

        const channel = pusher.subscribe(`Chat-${chatId}`);
        channel.bind('chat', (data) => {
            const newMessage = {
                message: data.message.message || data.message,
                user_id: data.message.user_id,
            };
            setMessages((prevMessages) => [...prevMessages, newMessage]);
        });

        return () => {
            channel.unbind_all();
            channel.unsubscribe();
            pusher.disconnect();
        };
    }, [chatId]);

    const handleSend = async () => {
        if (!message.trim()) return;
        if (!chatId) {
            setError('No active chat session');
            return;
        }

        try {
            const response = await fetch(`http://127.0.0.1:8000/api/message/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${localStorage.getItem('authToken')}`,
                },
                body: JSON.stringify({
                    message: message,
                    chat_id: chatId, // Use chatId from state
                }),
            });

            if (!response.ok) {
                throw new Error('Failed to send message');
            }

            setNewMessage(''); // Clear input on success
            scrollToBottom();
        } catch (error) {
            console.error('Error sending message:', error);
            setError('Failed to send message');
        }
    };

    // Clear error on user interaction
    const handleInputChange = (e) => {
        setNewMessage(e.target.value);
        if (error) setError(null);
    };

    return (
        <div
            className="container col-md-5 mt-5 pt-5 col-12 d-flex flex-column p-4 rounded"
            style={{ height: '80vh' }}
        >
            {loading && (
                <div className="position-absolute w-100 h-100 d-flex align-items-center justify-content-center bg-light opacity-75">
                    <p>Loading...</p>
                </div>
            )}
            {error && (
                <p className="text-danger text-center">
                    Error: {error} <button onClick={fetchChat}>Retry</button>
                </p>
            )}

            {/* Header */}
            <div className="p-3 border-bottom bg-primary text-white sticky-top">
                <h5 className="mb-0">Chat with {specialistName}</h5>
            </div>

            {/* Messages */}
            <div className="flex-grow-1 p-3 overflow-auto" style={{ backgroundColor: '#f1f2f6' }}>
                {messages.map((msg, i) => (
                    <div
                        key={i}
                        className={`mb-2 ${msg.user_id == userId ? 'text-end' : 'text-start'}`}
                    >
                        <div
                            className={`d-inline-block px-3 py-2 rounded-3 shadow-sm ${
                                msg.user_id == userId ? 'bg-primary text-white' : 'bg-light'
                            }`}
                            style={{ maxWidth: '60%' }}
                        >
                            <small>{msg.message}</small>
                        </div>
                    </div>
                ))}
                <div ref={messagesEndRef}></div>
            </div>

            {/* Input */}
            <div className="border-top bg-white sticky-bottom border rounded">
                <div className="input-group">
                    <input
                        type="text"
                        className="form-control border-0"
                        placeholder="Type your message..."
                        value={message}
                        onChange={handleInputChange}
                        onKeyDown={(e) => e.key === 'Enter' && handleSend()}
                    />
                    <button className="btn btn-primary m-0" onClick={handleSend}>
                        Send
                    </button>
                </div>
            </div>
        </div>
    );
};

export default ChatCanvas;
