import React from 'react';
import "./index.css";
import { BrowserRouter, Routes, Route } from "react-router-dom"
import Home from './Home';
import About from './About';
import Aichatbot from './Aichatbot';
import Login from './logintest';
import Signup from './Signup';
import ForgotPassword from './ForgotPassword';
import Description from "./Description";
import Recommendation from "./Recommendation";
import Whole from './Whole';
import Checkout from './components/Checkout';
import Newlogin from './Newlogin';
import SpecialistChat from './SpecialistChat';
import Chat from './Chat'
import CartView from "./CartView";
import UserCartComponent from './components/UserCartComponent';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';

import Logout from './Logout';
function App() {
  return (
    <>
    < BrowserRouter>

    <Routes>

   <Route path="/*"  element={<Home/>}></Route>
    <Route path="/About"  element={<About/>}/>
    <Route path="/Ai chatbot"  element={<Aichatbot/>}/>
    <Route path="/Login"  element={<Login/>}/>
    <Route path="/Signup"  element={<Signup/>}/>
    <Route path="/Whole"  element={<Whole/>}/>
      <Route path="/Description" element={<Description/>}/>
      <Route path="/Recommendation" element={<Recommendation/>}/>
      <Route path="/ForgotPassword" element={<ForgotPassword/>}/>
      <Route path="/Newlogin" element={<Newlogin/>}/>
      <Route path="/Logout" element={<Logout/>}/>
      <Route path="/Checkout" element={<Checkout />} />
      <Route path="/SpecialistChat" element={<SpecialistChat />}  />
      <Route path="/Chat" element={<Chat />}  />
        <Route path="/cart" element={<CartView/>}  />
    </Routes>
    </BrowserRouter>


    </>
  );
}
export default App;
