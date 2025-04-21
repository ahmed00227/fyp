import React from "react";
import "./Chatbot.css"
import {Link} from "react-router-dom";
import Navbar from "./Navbar";
import Hero from "./Hero/Hero";
import Footer from "./Footer";




function Aichatbot() {
  return (
    <>
        <Navbar />
        <section id="hero" className="">
            <div className="container mt-5 pt-5">
                <div className="row align-items-center my-auto">
                    {/* Left Content */}
                    <div className="col-lg-6 text-center text-lg-start mb-4 mb-lg-0">
                        <h1 className="display-5 fw-bold mb-2" style={{color: '#09408c'}}>
                            How can <span style={{color: "#10526b"}}>MEDI</span><span style={{color: "#ddb10f"}}>FAST</span> assist you today?
                        </h1>
                        <p className="fw-bolder fs-4" style={{color: '#3491ba'}}>
                            Choose an option below to get started:
                            <br />
                            <span style={{color: '#0f5e86'}}>• Need a recommendation?</span> Chat with our smart AI assistant to find the right medicine for your symptoms.
                            <br />
                            <span style={{color: '#0f5e86'}}>• Already have a medicine in mind?</span> View detailed descriptions, usage instructions, and more.
                        </p>

                    </div>

                    {/* Right Image */}
                    <div className="col-lg-6 text-center">
                        <img
                            src="aiChatbot.svg"
                            alt="Medicine illustration"
                            className="img-fluid rounded-4 shadow-lg"
                            style={{maxHeight: '400px', objectFit: 'cover'}}
                        />
                    </div>
                </div>
            </div>
        </section>
        <div className="chatbot-container mb-5">

            <div className="header d-md-flex d-block m-0">
                <div className="logo m-0">
                    <img src="an.png" alt = "nothing" className="w-100"  />
                </div>
                <div className="mx-auto">
                    <div className="des text-center">
                        <h3>AI CHATBOT</h3>
                        <p>Your Personal Doctor</p>
                    </div>
                </div>
            </div>
            <div className="mode d-md-flex d-block mt-0">
                <Link to = "/Description"  className="btn btn-primary btn-lg px-4 rounded-4 shadow-sm text-capitalize">
                    Description Mode
                </Link>
                <Link to = "/Recommendation"  className="btn btn-primary btn-lg px-4 rounded-4 shadow-sm text-capitalize">
                    Recommendation mode
                </Link>
            </div>

        </div>
    <Footer/>
    </>

  );
}

export default Aichatbot;
