
import React from "react";

import { Inertia } from "@inertiajs/inertia";
import { InertiaLink } from "@inertiajs/inertia-react";
import axios from "axios";
import backgroundRectangle from "../../../public/assets/rect.png";
import ParentLayout from "./ParentLayout";



const Statistics = () => {
  

const api_url = import.meta.env.VITE_APP_URL

  return (
    <div className="container mx-auto py-8 h-48  justify-items-center mb-8">



        <div>
            <div className="text-white flex items-stretch space-x-60 py-24 h-72 px-24"  style={{ backgroundImage: `url(${backgroundRectangle})`}}>
                <div>

                    <img src={`${api_url ? api_url.concat("/assets/ph_student-fill.png") : "none"}`} className="h-24 space-y-24" alt="Student" />
                                <label > 150  </label>
                                <label > Students  </label>

                </div>
                <div >
    
                    <img src={`${api_url ? api_url.concat("/assets/lessons.png") : "none"}`} alt="Kindness"  className="h-24 space-y-24"/>
                    <label >006</label> 
                        <label >Lessons</label> 
                </div>

                <div >

                    <img src={`${api_url ? api_url.concat("/assets/meals.png") : "none"}`} alt="Dedication"  className="h-24 space-y-24"/>
                                   <label>  928 </label>
                    <label>  Meals per year </label>

                </div>
                <div >
                  
                    <img src={`${api_url ? api_url.concat("/assets/certified.png") : "none"}`}  className="h-24 space-y-24" />
                    <label >10</label>
                    <label >Certified Teachers</label>
                </div>
          

            
            </div>

          
        </div>
    </div>
  );
};
export default Statistics;