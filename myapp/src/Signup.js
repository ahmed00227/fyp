import React, { useState } from "react";
import './Signup.css';
import { RiUser3Fill, RiLockPasswordFill, RiMailAddFill } from 'react-icons/ri';
import { Link } from 'react-router-dom';
import Navbar from "./Navbar";
import Footer from "./Footer";
import { toast, ToastContainer } from 'react-toastify';
import { useNavigate } from 'react-router-dom';

function Signup() {

    const [username, setUsername] = useState('');
    const [passwordError, setPasswordError] = useState('');
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [confirm, confirmPassword] = useState('');

    const navigate = useNavigate();

    const handleSignup = async (event) => {
        event.preventDefault();
        if (password !== confirm) {
            setPasswordError("Passwords do not match.");
            return;
        }

        try {
            const response = await fetch('http://127.0.0.1:8000/api/signup', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    email,
                    password,
                    name: username,
                    password_confirmation: confirm,
                })
            });

            const contentType = response.headers.get('content-type');
            const data = contentType?.includes('application/json')
                ? await response.json()
                : await response.text();

            if (response.ok) {
                toast.success('Signup successful! Redirecting...', { autoClose: 2000 });
                setTimeout(() => navigate('/login'), 2500);
            } else {
                toast.error((data.message || data) || 'Signup failed.');
            }

        } catch (error) {
            console.error('Network error:', error);
            toast.error('Something went wrong. Check your connection.');
        }
    };

    return (
        <>
            <Navbar />
            <ToastContainer/>
            <div
                style={{
                    backgroundImage: 'url("./loginbackground.jpg")',
                    backgroundSize: 'cover',
                    backgroundPosition: 'center',
                    backgroundRepeat: 'no-repeat',
                    minHeight: '100vh',
                }}
            >
                <div className="container d-flex justify-content-center align-items-center" style={{ minHeight: '100vh' }}>
                    <div
                        className="card p-4 shadow-lg w-100"
                        style={{
                            maxWidth: '500px',
                            background: 'rgba(255, 255, 255, 0.8)',
                            borderRadius: '20px',
                        }}
                    >
                        <h2 className="text-center mb-4">SIGNUP</h2>
                        <form onSubmit={handleSignup}>
                            <div className="mb-3">
                                <label className="form-label">
                                    <RiUser3Fill className="me-2" />
                                    Username
                                </label>
                                <input
                                    type="text"
                                    className="form-control"
                                    required
                                    value={username}
                                    onChange={(e) => setUsername(e.target.value)}
                                />
                            </div>

                            <div className="mb-3">
                                <label className="form-label">
                                    <RiMailAddFill className="me-2" />
                                    Email
                                </label>
                                <input
                                    type="email"
                                    className="form-control"
                                    required
                                    value={email}
                                    onChange={(e) => setEmail(e.target.value)}
                                />
                            </div>

                            <div className="mb-3">
                                <label className="form-label">
                                    <RiLockPasswordFill className="me-2" />
                                    Password
                                </label>
                                <input
                                    type="password"
                                    className="form-control"
                                    required
                                    value={password}
                                    onChange={(e) => setPassword(e.target.value)}
                                />
                            </div>

                            <div className="mb-3">
                                <label className="form-label">
                                    <RiLockPasswordFill className="me-2" />
                                    Confirm Password
                                </label>
                                <input
                                    type="password"
                                    className={`form-control ${passwordError ? 'is-invalid' : ''}`}
                                    required
                                    value={confirm}
                                    onChange={(e) => confirmPassword(e.target.value)}
                                />
                                {passwordError && (
                                    <div className="invalid-feedback">{passwordError}</div>
                                )}
                            </div>

                            <button type="submit" className="btn btn-primary w-100 m-0 py-2">
                                Submit
                            </button>

                            <div className="text-center mt-3">
                                <p className="mb-0">
                                    Already have an account? <Link to="/login">Login</Link>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
                <Footer />
            </div>
        </>
    )
}

export default Signup;
