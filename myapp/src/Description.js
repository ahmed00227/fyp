import React, { useState, useRef, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { toast, ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import Message from './Message';
import "./Description.css";
import Navbar from "./Navbar";
import Footer from "./Footer";

function Description() {
    const [userMessage, setUserMessage] = useState(''); // State for user input
    const [messages, setMessages] = useState([]); // State for messages
    const navigate = useNavigate();
    const messagesEndRef = useRef(null); // Ref to the message container

    // Function to scroll to the bottom of the message container
    const scrollToBottom = () => {
        if (messagesEndRef.current) {
            messagesEndRef.current.scrollTo({
                top: messagesEndRef.current.scrollHeight,
                behavior: 'smooth', // Smooth scrolling
            });
        }
    };

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
    const sendMessage = async () => {
        const message = userMessage.trim();
        if (message) {
            setMessages(prevMessages => [...prevMessages, { user: 'User', content: message }]);
            setUserMessage('');

            try {
                const res = await fetch('http://127.0.0.1:8000/api/descriptions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        Authorization: `Bearer ${localStorage.getItem('authToken')}`,
                    },
                    body: JSON.stringify({ message }),
                });

                if (!res.ok) throw new Error('Network response was not ok');

                const data = await res.json();
                const { medicine, message: msg } = data;

                const details = `
${msg}

🔹 Name: ${medicine.name}
🔹 Composition: ${medicine.composition}
🔹 Uses: ${medicine.uses}
🔹 Side Effects: ${medicine.side_effects}
🔹 Manufacturer: ${medicine.manufacturer}
🔹 Excellent Review: ${medicine.excellent_review}
🔹 Average Review: ${medicine.average_review}
🔹 Poor Review: ${medicine.poor_review}
            `.trim();

                const responseMessage = { user: 'Bot', content: details };
                setMessages(prevMessages => [...prevMessages, responseMessage]);

            } catch (error) {
                console.error('Error:', error);
            }
        }
    };

    const handleKeyPress = (event) => {
        if (event.key === 'Enter') {
            sendMessage();
        }
    };

    const handleChange = (event) => {
        setUserMessage(event.target.value);
    };

    return (
        <>
            <ToastContainer />
            <Navbar />
            <div
                className="Ai mt-5 pt-5"
                style={{
                    backgroundImage: 'url("./loginbackground.jpg")',
                    backgroundSize: 'cover',
                    backgroundPosition: 'center',
                    backgroundRepeat: 'no-repeat',
                }}
            >
                <div className="chatbox mt-3">
                    <h2>Description Mode</h2>
                    <ul ref={messagesEndRef}>
                        <div className="message-container">
                            {messages.map((message, index) => (
                                <Message key={index} user={message.user} content={message.content} />
                            ))}
                        </div>
                    </ul>
                    <input
                        type="text"
                        placeholder="Type your message..."
                        value={userMessage}
                        onChange={handleChange}
                        onKeyPress={handleKeyPress}
                    />
                </div>
                <Footer />
            </div>
        </>
    );
}

export default Description;
