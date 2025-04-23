import Navbar from "./Navbar";
import React from 'react';
import Footer from "./Footer";
import {Link} from "react-router-dom";
import { useNavigate } from 'react-router-dom';


const SpecialistChat = () => {
    const navigate = useNavigate();

    const handleStartChat = (specialistName , specialistRoute) => {
        navigate('./ChatCanvas', { state: { specialistName , specialistRoute } });
    };
    const doctors = [
        {
            title: 'Heart Specialist',
            description: 'Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.',
            buttonText: 'Start a Chat',
            image: 'heartspecilist.jpg',
            value: 'Cardiologist'
        },
        {
            title: 'Dental Specialist',
            description: 'Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.',
            buttonText: 'Start a Chat',
            image: 'dentist-specialist.jpg',
            value: 'Dentist'
        },
        {
            title: 'Kidney Specialist',
            description: 'Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.',
            buttonText: 'Start a Chat',
            image: 'kidneyspecialist.jpg',
            value: 'Nephrologist'
        },
        {
            title: 'Medical Specialist',
            description: 'Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.',
            buttonText: 'Start a Chat',
            image: 'medicalspecialist.jpg',
            value: 'General Physician'
        },
        {
            title: 'Skin Specialist',
            description: 'Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.',
            buttonText: 'Start a Chat',
            image: 'skinspecialist.jpg',
            value: 'Dermatologist'
        },
        {
            title: 'Child Specialist',
            description: 'Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.',
            buttonText: 'Start a Chat',
            image: 'childspecialist.jpg',
            value: 'Cardiologist'
        }
    ];

    return (
        <>
            <Navbar />
            <div className="container mt-4 pt-5">
                <div className="row mt-5">
                    {doctors.map((doctor, index) => (
                        <div className="col-md-4 mb-4 d-flex justify-content-center" key={index}>
                            <div className="card h-100 shadow-sm border rounded-3 overflow-hidden">
                                <img src={doctor.image} className="card-img-top" alt="Card visual" />
                                <div className="card-body  text-white d-flex flex-column justify-content-between" style={{background : '#096577'}}>
                                    <div>
                                        <h5 className="card-title fw-bold">{doctor.title}</h5>
                                        <p className="card-text">{doctor.description}</p>
                                    </div>
                                    <Link
                                        to="/Chat"
                                        state={{ specialistName: doctor.title , specialistRoute: doctor.value }} // ✅ this passes the data
                                        className="text-white btn ms-0 mt-3 align-self-start text-capitalize"
                                        style={{ background: '#063444' }}
                                    >
                                        {doctor.buttonText} <i className="fa-solid fa-arrow-right ms-2"></i>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
            <Footer/>
        </>
    );
};

export default SpecialistChat;
