import "./Hero.css";
import { Link } from "react-router-dom";

const Hero = () => {
    return (
        <>
        <section id="hero" className="">
            <div className="container mt-5 pt-5">
                <div className="row align-items-center my-auto">
                    {/* Left Content */}
                    <div className="col-lg-6 text-center text-lg-start mb-4 mb-lg-0">
                        <h1 className="display-5 fw-bold  mb-2" style={{color: '#09408c'}}>Welcome to our <span
                            style={{color: "#10526b"}}>MEDI</span><span style={{color: "#ddb10f"}}>FAST</span></h1>
                        <p className="fw-bolder fs-4" style={{color: '#3491ba'}}>The store aims to create a seamless
                            shopping experience for its customers, with high-quality products
                            and expert support readily available online.</p>
                        <Link to="/Whole" className="btn btn-primary btn-lg px-4 rounded-4 shadow-sm">
                            Shop Now
                            <i className="fa-solid fa-arrow-right ms-2"></i>
                        </Link>
                    </div>

                    {/* Right Image */}
                    <div className="col-lg-6 text-center">
                        <img
                            src="gifgit.png"
                            alt="Medicine illustration"
                            className="img-fluid rounded-4 shadow-lg"
                            style={{maxHeight: '400px', objectFit: 'cover'}}
                        />
                    </div>

                </div>
            </div>
        </section>
        </>
    );
};

export default Hero;
