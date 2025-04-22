import React, { useState } from 'react';

import ChatCanvas from './ChatCanvas';
import Navbar from "./Navbar";
import Footer from "./Footer";
import {Link} from "react-router-dom";

const ChatPage = () => {
    return (
        <>
        <Navbar />
            <div style={{overflowY : 'scroll'}}>
        <ChatCanvas/>
            </div>
         <div className="w-100 mt-4" style={{position : '' , bottom : '0px'}}>
             <Footer />
         </div>
        </>
    );
};

export default ChatPage;
