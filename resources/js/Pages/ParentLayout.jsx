import React from "react";
import background from "../../../public/assets/rectangle33.png"
import logo from "../../../public/assets/logo.png"
import email from "../../../public/assets/baseline-email.png"
import phone from "../../../public/assets/phone-fill.png"
import location from "../../../public/assets/location.png"
import workingHours from "../../../public/assets/ion_time.png"
import navbarImage from "../../../public/assets/rectangle9.png"
import rectangleImage from "../../../public/assets/rectangle33.png"
import { Link } from '@inertiajs/inertia-react';
import Phone from "../../../public/assets/iPhoneSE.png"
import Email from "../../../public/assets/Email.png"
import Location from "../../../public/assets/Location.png"


const ParentLayout = ({children}) => {
   
    return (
        <div>

             <nav className="h-16" style={{ backgroundImage: `url(${navbarImage})`}}>
              <ul className="grid grid-flow-col justify-items-end p-4 py-4 text-white h-8 space-x-8">
                <li className="h-8" style={{ backgroundImage: `url(${Phone})` , backgroundRepeat: "no-repeat" , backgroundSize: "30px" }} >
               <p className="px-8">0721633782/0717539365</p> 
                </li>
              
              
                <li  className="h-8" style={{ backgroundImage: `url(${Email})` ,  backgroundRepeat: "no-repeat",  backgroundSize: "30px" }} >
                  <p className="px-8">littlelionsjunior@gmail.com</p>
                </li>

                <li  style={{ backgroundImage: `url(${Location})`, backgroundRepeat: "no-repeat" ,   backgroundSize: "30px"}}>
                 <p className="px-8">  Olympic</p> 
                </li>
              </ul>
      {/* Navigation content */}
      </nav>
      <nav>
      <ul className="grid grid-flow-col justify-items-end p-8">
        <li>
        <img src={logo} className="justify-items-start  h-20" />
        </li>
        <li style={{ fontFamily: "Rubik"}}>
        <Link href="/home"> Home </Link>
        </li>
        <li style={{ fontFamily: "Rubik"}}>
        <Link href="/programs"> Programs </Link>
        </li>
        <li style={{ fontFamily: "Rubik"}}>
        <Link href="/gallery"> Gallery </Link>
        </li>
        <li style={{ fontFamily: "Rubik"}}>
        <Link href="/contact"> Contact us </Link>
        </li>
        <li style={{ fontFamily: "Rubik"}}>
        <Link href="/paypal" className="bg-sky-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"> Donate </Link>
        </li>
      </ul>
      </nav>
      {children}
      <footer>
      <div className="h-96" style={{ backgroundImage: `url(${background})` }}>
        <div className="flex items-stretch justify-left  space-x-24 py-4">
        <img src={logo} alt="" className="h-24 px-8" /> <label className="font-semibold py-4 -ml-2">Little Lions <br />Junior School</label>
        </div>
        <div className="flex items-stretch">
        <p className="px-8" style={{ fontFamily: "Rubik"}}>
          Welcome to Little Lion Junior School, <br />
          where education inspires and empowers <br />
          every student to excel. We foster a collaborative <br />
          community that makes a difference. Our CBC curriculum <br />
          blends tradition with innovation, <br />
          preparing students for a global <br />
          future. Explore our programs, values, and vibrant community. <br />
        </p>
        <div className="grid-cols-1 px-32">
          <h2 className="text-2xl font-normal -mt-24" style={{ fontFamily: "Rubik"}}>CONTACT INFO </h2>
          <div className="flex items-center space-x-2 my-2 py-4">
          <img src={location} alt="" className="h-8" />
          <span><label htmlFor="">Location</label></span>
          </div>
          <div className="flex items-center space-x-2 my-2 py-4">
          <img src={phone} alt="" className="h-8" />
          <span><label htmlFor="" style={{ fontFamily: "Rubik"}}>0721633782/0717539365</label></span>
          </div>
          <div className="flex items-center space-x-2 my-2 py-4">
          <img src={email} alt="" className="h-8" />
          <span><label htmlFor="" style={{ fontFamily: "Rubik"}} >littlelionsjunior@gmail.com</label></span>
          </div>
          <div className="flex items-center space-x-2 my-2 py-4">
          <img src={workingHours} alt="" className="h-8" />
          <span><label style={{ fontFamily: "Rubik"}}>8:00 am - 4:00 pm</label></span>
          </div>
        </div>

         <div className="grid-cols-1 px-32">
          <h2 className="text-2xl font-normal -mt-24" style={{ fontFamily: "Rubik"}}>QUICK LINKS </h2>
          <div className="flex items-center space-x-2 my-2">
          
          <li style={{ fontFamily: "Rubik"}} className="py-6"> <Link href="/contact">Contact Us</Link></li>
          </div>
          <div className="flex items-center space-x-2 my-2">
                    <li className="py-6" style={{ fontFamily: "Rubik"}}> <Link href="/paypal">Donate</Link></li>

          </div>
          <div className="flex items-center space-x-2 my-2">
                  <li className="py-4"  style={{ fontFamily: "Rubik"}}> <Link href="/programs">Programs</Link></li>

          </div>
          <div className="flex items-center space-x-2 my-2">
                    <li className="py-4" style={{ fontFamily: "Rubik"}}> <Link href="/gallery"> Gallery</Link></li>

          </div>
        </div>
        </div>
      </div>
      </footer>
        </div>
    )

} 

export default ParentLayout;