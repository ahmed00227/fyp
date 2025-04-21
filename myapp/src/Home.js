import React, { useState } from 'react';
import { Link } from 'react-router-dom'
import "./Home.css"
import {RiSearchLine} from "react-icons/ri";
import {RiShoppingCartFill} from "react-icons/ri";
import Hero from './Hero/Hero';
import Footer from './Footer';
import  Navbar  from './Navbar';
import  Service  from './Service.js';

function Home () {
  
  return (
    <>
   <Navbar />
    <Hero/>
        <Service />
    <Footer/>
    </>
  )
}

export default Home;


