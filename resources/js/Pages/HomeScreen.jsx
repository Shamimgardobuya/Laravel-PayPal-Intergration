
import React from "react";
import axios from "axios";
import Values from "./Values";
import Statistics from "./Statistics";
import Staff from "./Staff";
import ParentLayout from "./ParentLayout";

import school from "../../../public/assets/school_.jpeg"



const HomeScreen = () => {
  const handleClick = () => {
    // const root = document.getElementById("root")
    // Inertia.get("/values");
    // ReactDOM.createRoot(root).render(
    //   <BrowserRouter
    //   >
    
       
    
  };


  return (

    <div className="container ">
    <ParentLayout>
     
      <div className="h-136 mb-8  ml-32 -mt-4 " style={{ backgroundImage: `url(${school})`, backgroundRepeat: "no-repeat" , maxWidth: '100%'}}>
      <div className="py-32 px-12">
        <p className="py-8 text-4xl font-bold justify-items-start text-white">About Us</p>
        <p className="font-weight-500 text-white text-xl " style={{ fontFamily: "Rubik"}}>
        At Little Lion Junior School, we are dedicated <br /> to empowering young minds through innovative <br /> learning and a nurturing community.
        Our mission is <br />to inspire every student to reach their full potential <br />and thrive in an ever-changing world.
        </p>
        <button
        onClick={handleClick}
        className="bg-green-900 text-white mt-24  w-32 h-8  rounded"
        >
        Scroll down
        </button>
      </div>
      </div>
      <section>
      <Values />
      </section>
      <section>
      <Statistics />
      </section>
      <section>
      <Staff />
      </section>

    </ParentLayout>
     
    </div>
    );
};
export default HomeScreen;