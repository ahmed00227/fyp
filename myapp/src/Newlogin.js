import React, { useState } from "react";
import  './Login.css';
import {RiUser3Fill ,RiLockPasswordFill } from 'react-icons/ri';
import Newbar from "./Newbar";
import Footer from "./Footer";

const Newlogin =()=>{
    const [username, setUsername] = useState("");
    const [password, setPassword] = useState("");
  
    const handleUsernameChange = (event) => {
      setUsername(event.target.value);
    };
  
    const handlePasswordChange = (event) => {
      setPassword(event.target.value);
    };
  
    const handleSubmit = (event) => {
      event.preventDefault();
  
      // Validate username
      const usernameRegex = /^(?=.*[a-z_])(?=.*[A-Z0-9_]).{4,15}$/;
  
      if (!usernameRegex.test(username)) {
        alert('Username must be 4-15 characters (letters, numbers, underscores)');
        return;
      }
  
      // Validate password
      const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{4,9}$/;
      if (!passwordRegex.test(password)) {
        alert('Password must be 4-9 characters and include lowercase, uppercase, numbers, and symbols');
        return;
      }
  
      // If validations pass, you can proceed with login
      console.log('Login successful! Username:', username, 'Password:', password);
  
      // Clear username and password fields after successful login
      setUsername('');
      setPassword('');
    };
    return(
      <>
     <Newbar/>
        <div className="wa">
        <div className="login">
            <h2 className="heading">
                LOGIN
            </h2>
            <form className="ff" onSubmit={handleSubmit}>
            <div className="login-form">
                <label htmlfor="username" className="form-label"><RiUser3Fill/>  Username</label>
                <input  
                type="username"
                className="form-control"
                id="username"
                required
                value={username}
                onChange={handleUsernameChange}
                autoComplete="off"  ></input>  
            </div>
            <div className="login-form">
                <label htmlfor="password"  className="form-label"> <RiLockPasswordFill/>  Password <a  href="ForgotPassword" className="pass">Forget Password</a>
                </label>
                <input 
                 type="password"
                className="form-control"
                id="password"
                required
                value={password}
                onChange={handlePasswordChange}
                autoComplete="off"></input>
            </div>
            <button type="Submit" className="login-button">Submit</button>
            <div className="login-form-footer">
            <p>Don't have an account? <a href="Signup">Signup</a></p>
            </div>
            </form>
        </div>
   </div>
   <Footer/>
        </>
    )
}
export default Newlogin;
