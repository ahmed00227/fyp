import React, { useState, useEffect, useRef } from 'react';
import { useLocation } from "react-router-dom";

const ChatCanvas = () => {
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);
    const [messages, setMessages] = useState([]);
    const [message, setNewMessage] = useState('');
    // const [isTyping, setIsTyping] = useState(false);
    const messagesEndRef = useRef(null);
    const location = useLocation();
    const specialistName = location.state?.specialistName;
    const specialistRoute = location.state?.specialistRoute || 'default-route';
    useEffect(() => {
        if (!location.state?.specialistRoute) {
            console.warn("Missing specialistRoute. Make sure you navigated using the correct Link.");
            // Optional: redirect back
            // navigate('/SpecialistList');
        }
    }, []);

    useEffect(() => {
        scrollToBottom();
    }, [messages]);

    const scrollToBottom = () => {
        messagesEndRef.current?.scrollIntoView({ behavior: 'smooth' });
    };


    const fetchChat = async () => {
        try {
            setLoading(true);
            setError(null);

            const response = await fetch(`http://127.0.0.1:8000/api/chat/${specialistRoute}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                },
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();
            localStorage.setItem('chatId', data.chat.id);
            // setMessages(data.messages && data.messages.length > 0 ? data.messages : '');

            setMessages(data.messages || []); // Use correct response key

        } catch (err) {
            setError(err.message);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        const authToken = localStorage.getItem('authToken');
        if (authToken && specialistRoute) {
            fetchChat();
        }
    }, [specialistRoute]);

    const handleSend = async () => {
        if (!message.trim()) return;
        
        setNewMessage('');
        scrollToBottom();

        try {
            const response = await fetch(`http://127.0.0.1:8000/api/message/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('authToken')}`,
                },
                body: JSON.stringify({
                    message: message,
                    chat_id: localStorage.getItem('chatId'), // Or use correct chat ID
                }),
            });

            if (!response.ok) {
                console.log('response' , response)
                throw new Error('Failed to send message');
            }

        } catch (error) {
            console.error('Error sending message:', error);
            setError('Failed to send message');
        }
    };
    useEffect(() => {
        const authToken = localStorage.getItem('authToken');
        if (authToken && specialistRoute) {
            localStorage.removeItem('chatId');
            fetchChat();
        }
    }, [specialistRoute]);
    useEffect(() => {
        return () => {
            localStorage.removeItem('chatId');
        };
    }, []);



    return (
        <div className="container col-md-5 mt-5 pt-5 col-12 d-flex flex-column p-4 rounded" style={{ height: '80vh' }}>
            {loading && <p>Loading...</p>}
            {error && <p>Error: {error}</p>}
            {/* Header */}
            <div className="p-3 border-bottom bg-primary text-white sticky-top">
                <h5 className="mb-0">Chat with {specialistName}</h5>
            </div>

            {/* Messages */}
            <div className="flex-grow-1 p-3 overflow-auto" style={{ backgroundColor: '#f1f2f6' }}>
                {messages.map((msg, i) => (
                    <div key={i} className={`mb-2 ${msg.user_id==localStorage.getItem('userId') ? 'text-end' : 'text-start'}`}>
                        <div
                            className={`d-inline-block px-3 py-2 rounded-3 shadow-sm ${
                                msg.user_id==localStorage.getItem('userId') ? 'bg-primary text-white' : 'bg-light'
                            }`}
                            style={{ maxWidth: '60%' }}
                        >
                            <small>{msg.message}</small>
                        </div>
                    </div>
                ))}
                {/*{isTyping && (*/}
                {/*    <div className="text-start mb-2">*/}
                {/*        <div className="d-inline-block px-3 py-2 rounded-pill bg-light text-muted">*/}
                {/*            <em>John is typing...</em>*/}
                {/*        </div>*/}
                {/*    </div>*/}
                {/*)}*/}
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
                        onChange={(e) => setNewMessage(e.target.value)}
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
