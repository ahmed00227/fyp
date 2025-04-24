import React, { useState, useEffect } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import "./Home.css";
import { RiSearchLine, RiShoppingCartFill } from "react-icons/ri";
import { toast ,ToastContainer} from 'react-toastify';

const Home = () => {
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const navigate = useNavigate();

  useEffect(() => {
    const token = localStorage.getItem('authToken');
    setIsLoggedIn(!!token); // true if token exists
  }, []);

  const handleLogout = () => {
    localStorage.removeItem('authToken');
    localStorage.removeItem('userId');
    setIsLoggedIn(false);
    toast.success("Logout Successful!");
      navigate('/Login');
  };

  return (
      <>
          <ToastContainer />
          <header>
          <nav className="navbar navbar-expand-lg navbar-light bn-cont fixed-top py-2">
            <div className="container">
              <Link className="navbar-brand d-flex align-items-center" to="/Home">
                <img src="medifast-remove.png" alt="go" className="go me-2" style={{ width: "40px", height: "40px" }} />
                <h3 className='medifst-logo mb-0'>
                  <span style={{ color: "#10526b" }}>MEDI</span><span style={{ color: "#f7d756" }}>FAST</span>
                </h3>
              </Link>

              <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span className="navbar-toggler-icon"></span>
              </button>

              <div className="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul className="navbar-nav mb-2 mb-lg-0 d-flex col-md-9 col-12 justify-content-end">
                  <li className="nav-item">
                    <Link className="nav-link" to="/Home">HOME</Link>
                  </li>
                  <li className="nav-item">
                    <Link className="nav-link" to="/Ai chatbot">AI CHATBOT</Link>
                  </li>
                  <li className="nav-item">
                    <Link className="nav-link" to="/About">ABOUT US</Link>
                  </li>
                  <li className="nav-item">
                    <Link className="nav-link" to="/SpecialistChat">CHAT WITH SPECIALIST</Link>
                  </li>
                  <li className="nav-item">
                    <Link className="nav-link" to="/Whole">PRODUCTS</Link>
                  </li>
                    <li className="nav-item">
                        <Link className="nav-link" to="/MyOrder">ORDERS</Link>
                    </li>
                </ul>

                <ul className="navbar-nav d-flex align-items-center col-md-3 col-12 justify-content-end">
                  {isLoggedIn && (
                      <li className="nav-item me-3 position-relative">
                        <Link className="nav-link fs-4" to="/cart">
                          <RiShoppingCartFill />
                          <sup className="bg-danger text-white" style={{borderRadius: '50%',
                            padding: '2px 5px',
                            fontSize: '16px',
                            width: '20px',
                            height: '20px',}} >{localStorage.getItem('count')?? 0}</sup>
                        </Link>
                      </li>
                  )}

                  {!isLoggedIn ? (
                      <>
                        <li className="nav-item">
                          <Link className="nav-link" to="/Login">LOGIN</Link>
                        </li>
                        <li className="nav-item">
                          <Link className="nav-link" to="/Signup">SIGNUP</Link>
                        </li>
                      </>
                  ) : (
                      <li className="nav-item">
                        <button className="nav-link btn btn-link m-0" onClick={handleLogout}>LOGOUT</button>
                      </li>
                  )}
                </ul>
              </div>
            </div>
          </nav>
        </header>
      </>
  );
};

export default Home;
