import React, { useState, useEffect, useRef } from 'react';
import {useLocation} from "react-router-dom";

const ChatCanvas = () => {
    const [messages, setMessages] = useState([
        { text: 'Hi there!', sentByMe: false, timestamp: new Date() },
        { text: 'Hello! How are you?', sentByMe: true, timestamp: new Date() }
    ]);
    const [newMessage, setNewMessage] = useState('');
    const [isTyping, setIsTyping] = useState(false);
    const messagesEndRef = useRef(null);
    const location = useLocation();
    const specialistName = location.state?.specialistName;


    useEffect(() => {
        scrollToBottom();
    }, [messages]);

    const scrollToBottom = () => {
        messagesEndRef.current?.scrollIntoView({ behavior: 'smooth' });
    };

    const handleSend = () => {
        if (!newMessage.trim()) return;

        const sentMessage = {
            text: newMessage,
            sentByMe: true,
            timestamp: new Date()
        };

        setMessages((prev) => [...prev, sentMessage]);
        setNewMessage('');
        setIsTyping(true);

        setTimeout(() => {
            setMessages((prev) => [
                ...prev,
                {
                    text: "That's great! Tell me more.",
                    sentByMe: false,
                    timestamp: new Date()
                }
            ]);
            setIsTyping(false);
        }, 1500);
    };

    return (
        <div className="container col-md-5 mt-5 pt-5 col-12  d-flex flex-column p-4 rounded " style={{height : '80vh'}}>
            {/* Header */}
            <div className="p-3 border-bottom bg-primary text-white sticky-top">
                <h5 className="mb-0">Chat with {specialistName}</h5>
            </div>

            {/* Messages */}
            <div className="flex-grow-1 p-3 overflow-auto" style={{ backgroundColor: '#f1f2f6' }}>
                {messages.map((msg, i) => (
                    <div key={i} className={`mb-2 ${msg.sentByMe ? 'text-end' : 'text-start'}`}>
                        <div
                            className={`d-inline-block px-3 py-2 rounded-3 shadow-sm ${
                                msg.sentByMe ? 'bg-primary text-white' : 'bg-light'
                            }`}
                            style={{ maxWidth: '60%' }}
                        >
                            <small>{msg.text}</small>
                        </div>
                    </div>
                ))}
                {isTyping && (
                    <div className="text-start mb-2">
                        <div className="d-inline-block px-3 py-2 rounded-pill bg-light text-muted">
                            <em>John is typing...</em>
                        </div>
                    </div>
                )}
                <div ref={messagesEndRef}></div>
            </div>

            {/* Input */}
            <div className=" border-top bg-white sticky-bottom border rounded">
                <div className="input-group">
                    <input
                        type="text"
                        className="form-control border-0"
                        placeholder="Type your message..."
                        value={newMessage}
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
