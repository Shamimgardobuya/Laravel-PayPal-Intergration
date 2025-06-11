import React from "react";
import programsImage from "../../../public/assets/rectangle124.png"
import activtiesImage from "../../../public/assets/group29.png"
import literacy from "../../../public/assets/literacy.png"
import math from "../../../public/assets/bx_math.png"
import environment from "../../../public/assets/tree.png"
import swahili from "../../../public/assets/palm-tree.png"
import art from "../../../public/assets/mdi_art.png"
import exercise from "../../../public/assets/exercise.png"
import ParentLayout from "./ParentLayout";



const Programs = () => {

    return (
        <div className="container " style={{ fontFamily: "Rubik" }}>
            <ParentLayout>
        <div className=" h-96  mt-24 w-full ml-20" style={{ backgroundImage : `url(${programsImage})`, backgroundRepeat: "no-repeat" }}>
            <h1 className="text-white  text-2xl " style={{ fontFamily: "Rubik"}}>Learning center for  <br />Your kids</h1>

            <p className="text-white" style={{ fontFamily: "Rubik"}}>Welcome to Little Lion Junior School, where we empower <br /> students through a collaborative community and <br /> innovative CBC curriculum for global success.</p>

        
      

        </div>
          {/* <section> */}
            <div className="h-96 ml-20 -mt-20" style={{backgroundImage : `url(${activtiesImage})`}} ></div>
        {/* </section> */}

        <div className="grid place-items-center py-8">

            <h1 className="text-black text-2xl ">
                What we Offer
            </h1>
            <p className="text-black" > At Little Lion Junior School, we offer a dynamic CBC curriculum that blends traditional and  <br />innovative learning, empowering students to excel and thrive in a global society.</p>
        </div>

        <div className="ml-24  grid  grid-cols-3 gap-4  ">
        
         <div>
            <img className="h-12" src={literacy} alt="" />
            <p  >Literacy classes</p>
            <p >Enhances reading, writing, and <br /> communication skills through <br />interactive activities.</p>
         </div>
        <div>
            <img className="h-12" src={math} alt="" />
            <p>Math class</p>
            <p>Focuses on hands-on problem-solving <br /> and numeracy skills <br /> using real-life examples. </p>
         </div>

         <div>
            <img className="h-12" src={environment} alt="" />
            <p>Environmental classes</p>Teaches students about nature,<br /> sustainability, and <br />environmental conservation.
            <p></p>
         </div>
        </div>

        <div  className="ml-24 grid  grid-cols-3 gap-4" >
         

        <div>
            <img className="h-12" src={swahili} alt="" />
            <p>Kiswahili classes</p>
            <p>Develops communication skills <br /> in Kiswahili through interactive <br />  learning and storytelling.</p>
         </div>


         <div>
            <img className="h-12" src={art} alt="" />
            <p>Creative Arts</p>
            <p>Encourages creativity and  <br />imagination through drawing <br />, music, drama, and other forms <br />of artistic expression.</p>
         </div>

         <div>
            <img className="h-12" src={exercise} alt="" />
            <p> Physical & Health Education (PHE) </p>
            <p>Promotes physical fitness and <br />healthy living through sports <br />, exercises, and health awareness <br /> activities.</p>
         </div>



        


        </div>
        </ParentLayout>
        </div>
    )

}
export default Programs;