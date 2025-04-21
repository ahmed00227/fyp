import React from 'react';
import Navbar from './Navbar';
import Footer from './Footer';
import './About.css';

const About = () => {
    return (
        <div className='gh'>
            <Navbar />

            {/* 🔥 Hero Section */}
            <section className="hero-section text-white d-flex align-items-center justify-content-center mt-5 position-relative" style={{
                backgroundImage: `url('/aboutus.jpg')`,
                backgroundSize: 'cover',
                backgroundPosition: 'center',
                backgroundRepeat: 'no-repeat',
                height: '50vh',
            }}>
                <div className="overlay position-absolute w-100 h-100" style={{
                    backgroundColor: 'rgba(0, 0, 0, 0.5)',
                    top: 0,
                    left: 0,
                    zIndex: 1
                }}></div>
                <div className="text-center text-white px-3 position-relative" style={{ zIndex: 2 }}>
                    <h1 className="display-4 fw-bold">ABOUT US</h1>
                    <p className="lead mt-3">MediFast - Bridging Wellness with Speed</p>
                    <p className="fs-5">Your Path to Health, Swiftly.</p>
                </div>
            </section>

            {/* 🧾 About Content */}
            <section id='ab' className="py-5 container">
                <div className='about'>

                    <h2 className="section-title">What is MediFast?</h2>
                    <p className='section-text'>
                        Medifast is a next-generation eCommerce platform built to transform the way people discover and purchase medical products. We go beyond online shopping — offering 24/7 access to licensed medical specialists through live chat, an AI-powered chatbot that recommends medication based on your symptoms, and a dynamic medicine insights system providing detailed descriptions, benefits, drawbacks, composition, manufacturer data, and community ratings. At Medifast, we blend innovation with compassion to bring smarter, safer, and more personalized healthcare to your doorstep.
                    </p>

                    <h2 className='section-title'>Our Journey and Goal</h2>
                    <p className='section-text'>
                        Our journey started with a vision: to make healthcare more accessible, transparent, and patient-focused. With a team of experts in healthcare and technology, MediFast is committed to bridging the gap between quality medical supplies and everyday users. We ensure affordability, timely deliveries, and expert-backed service through tools like virtual consultations and AI-based medication discovery. Your health, your pace — guided by trust, powered by innovation.
                    </p>

                    <h2 className='section-title'>Why Choose MediFast?</h2>
                    <p className='section-subtitle'>
                        Experience intelligent healthcare with MEDIFAST'S AI CHATBOT
                    </p>
                    <p className='section-text'>
                        Whether you're unsure about symptoms or curious about a drug’s details, our AI chatbot helps you get personalized medication suggestions and real-time answers from experts. Backed by data and developed for you, MediFast puts wellness within reach.
                    </p>
                    <p className='section-text'>
                        In addition, our platform ensures access to high-quality, affordable medical supplies, fast delivery, and secure data handling. With dedicated support, a knowledgeable team, and a focus on user convenience, MediFast is designed to be your all-in-one digital healthcare partner. From first symptom to full recovery, we’re here every step of the way.
                    </p>
                    <p className='section-text'>
                        Choose MediFast for innovation-driven care, transparency, and a seamless health journey — anytime, anywhere.
                    </p>
                </div>
            </section>

            <Footer />
        </div>
    );
};

export default About;
