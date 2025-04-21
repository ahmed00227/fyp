import React, { useState } from "react";
import './Login.css';
import { RiUser3Fill, RiLockPasswordFill } from 'react-icons/ri';
import Navbar from "./Navbar";
import Footer from "./Footer";
import {Link, useNavigate} from "react-router-dom";
import { toast, ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import {rgbToHex} from "@mui/material";

const Login = () => {

    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const navigate = useNavigate();

    const handleEmailChange = (event) => {
      setEmail(event.target.value);
    };

    const handlePasswordChange = (event) => {
      setPassword(event.target.value);
    };

    async function handleSubmit(event) {
        event.preventDefault();
        try {
            const response = await fetch('http://127.0.0.1:8000/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    email: email,
                    password: password
                })
            });

            const data = await response.json(); // await the JSON response

            if (response.ok && data.success) {
                // Save the real token from the backend
                localStorage.setItem('authToken', data.token);
                localStorage.setItem('count',data.cart_count);
                toast.success("Login successful! Redirecting...");
                setTimeout(() => {
                    navigate('/Home');
                }, 2000);
            } else {
                toast.error(data.message || "Login failed");
            }
        } catch (error) {
            console.error('Error:', error);
            toast.error("Something went wrong. Please try again.");
        }
    }


    return (

        <div>
            <Navbar />
            <ToastContainer/>
            <div className="bg-image"  style={{ backgroundImage: 'url("./loginbackground.jpg")', backgroundSize: 'cover', backgroundPosition: 'center' , backgroundRepeat: 'no-repeat'}} >
            <div className="container d-flex justify-content-center align-items-center" style={{height : "90vh"}}>
                <div className="login-card  p-4 shadow-sm rounded col-md-5 col-12 mt-5 " style={{background : 'rgb(255, 255, 255, 0.5)'}}>
                    <h2 className="text-center mb-4">LOGIN</h2>
                    <form name="login" className="ff" onSubmit={handleSubmit} method="POST">
                        <div className="mb-3">
                            <label htmlFor="username" className="form-label">
                                <RiUser3Fill /> Username/Email
                            </label>
                            <input
                                type="text"
                                className="form-control"
                                id="username"
                                required
                                value={email}
                                onChange={handleEmailChange}
                                autoComplete="off"
                            />
                        </div>
                        <div className="mb-3">
                            <label htmlFor="password" className="form-label">
                                <RiLockPasswordFill /> Password
                            </label>
                            <input
                                type="password"
                                className="form-control"
                                id="password"
                                required
                                value={password}
                                onChange={handlePasswordChange}
                                autoComplete="off"
                            />
                        </div>
                        <div className="d-flex justify-content-center mb-3">
                            <button type="submit" className="btn btn-primary w-100 m-0 py-2 my-2">
                                Submit
                            </button>
                        </div>
                        <div className="text-center">
                            <p>
                                Don't have an account? <Link to="/signup">Signup</Link>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
            <Footer />
            </div>

        </div>
    );
};

export default Login;
