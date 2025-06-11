import React, { useState, useEffect } from "react";
import ParentLayout from "./ParentLayout";
import axios from "axios";
import { TileLayer, Marker } from "react-leaflet";
import { MapContainer } from "react-leaflet/MapContainer";
import 'leaflet/dist/leaflet.css';


const ContactScreen = () => {
    const [name , setName ] = useState(null)
    const [email, setEmail] = useState(null)
    const [subject, setSubject] = useState(null)
    const [message, setMessage] = useState(null) 
    const [csrfToken, setCsrfToken] = useState(null)
    const center = [-1.3143716,36.7807485]; // Example coordinates
    
    useEffect(() => {
    axios.get("/csrf-token").then((response) => {
      console.log("CSRF cookie set:", response);
      setCsrfToken(response.data.token);
      console.log(">>>>>>>>>CSRF Token:", response.data.token);
    });
  }, []); 
    
    const handleNameFunction =  (event) => {
        setName(event.target.value)

    }
    const handleEmailFunction =  (event)  => {
        setEmail(event.target.value)

    }
    const handleSubjectFunction  = (event) => {
        setSubject(event.target.value)

    }
    const handleMessageFunction = (event) => {
        setMessage(event.target.value)

    }
    const handleSubmit = (event)  => {
        console.log(email)
        event.preventDefault();
        
            axios.post(
                '/api/send-email',
                {
                    
                name : name,
                email : email,
                subject : subject,
                message : message
                },
                
                {
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    }
                },
                
            )
            .then(function (response) {
                    console.log(response);
                })
            .catch(function (error) {
                console.log(error);
            });
                    


    }
    return  (
     <div>
    <ParentLayout>
        <div className="grid place-items-center">
    <h1 className="font-semibold items-center text-xl" style={{ fontFamily: "Rubik"}}>Get In touch</h1>

    <p style={{ fontFamily: "Rubik"}} className="items-center">
        Reach out to us today and discover how Little Lion Junior School can be a part <br /> 
        of your child’s journey toward excellence. Let us guide and support them in <br />
        building a bright future filled with endless possibilities and success!
    </p>

      

    <form className="px-88 py-8" onSubmit={handleSubmit} style={{ width: "1155px", height: "807px" , fontFamily: "Rubik"}}>
        {/* @csrf (if using Laravel Blade, this should be handled differently in React) */}
        <div style={{ display: "flex", alignItems: "center", gap: "10px" }}>
            <input type="text" name="name" placeholder="Your Name" onChange={handleNameFunction} style={{ outline: "1px solid darkgreen", border: "none", padding: "8px", borderRadius: "0", margin: "2px" }} />
            <input type="text" name="email" placeholder="Email"  onChange={handleEmailFunction} style={{ outline: "1px solid darkgreen", border: "none", padding: "8px", borderRadius: "0", margin: "2px" }} />
        </div>
        <div>
            <input type="text" name="subject" placeholder="Subject"  onChange={handleSubjectFunction} style={{ outline: "1px solid darkgreen", border: "none", padding: "8px", borderRadius: "0", margin: "2px", width: "380px" }} />
        </div>
        <div>
            <input type="text" name="message" placeholder="Message"  onChange={handleMessageFunction} style={{ outline: "1px solid darkgreen", border: "none", padding: "8px", borderRadius: "0", width: "380px", height: "207px", marginTop: "5px", textAlign: "justify" }} />
        </div>
        <button type="submit" style={{ backgroundColor: "#013220", color: "white", width: "200px", height: "70px", borderRadius: "64px", fontFamily: "Rubik", fontSize: "18px", fontWeight: "bold", textAlign: "center", marginTop: "8px" }}>
            SEND MESSAGE
        </button>
    </form>
    </div>

    {/* map */}
    <div className="text-center scroll-smooth text-sm text-gray-500 ">
  ↓ Scroll down to see the map ↓
</div>
        
    
    <MapContainer center={center} zoom={10} style={{ height: '600px' , marginTop: "-90px" }} className="h-72 -mt-10">
           <TileLayer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" />
           <Marker position={center} />
         </MapContainer>
    </ParentLayout>
    </div>
    )
    
};

export default ContactScreen;