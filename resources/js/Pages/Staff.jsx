import React, { useEffect, useState } from "react";
import ParentLayout from "./ParentLayout";


const Staff = () => {
    const [staff, setStaff] =  useState(null)
    const [loading, setLoading ] = useState(true) //while data is being fetched 
    const  [error, setError ] = useState(null)
    useEffect( ()=> { // use effect with empty dependen aarray request is only made once when compononet mounts 
       
       
            axios.get(
                "/staff"
            ).then(
               function (response) {
                setStaff(response.data.data)
                setLoading(false)

                console.log(response.data)

               }
            ).catch(error => {
                setError(error)
                console.error('Error fetching data:', error);
            });


    },
   
    [])

    if (loading) {
    return <p>Loading...</p>;
    }

    if (error) {
        return <p>Error: {error.message}</p>;
    }

    if (!staff) {
        return <p>No data to display.</p>;
    }
    return (
        <div className="py-24 h-96 mt-32">
          <h1 className="text-2xl font-bold mb-4 text-center">Meet our Staff</h1>
          <div className="flex flex-wrap gap-4 p-4">
            {
                Array.isArray(staff) ?
                
                staff.map((stf, index) => 
                    <div key={index}  >
                       <img src={stf.image_path} alt="Staff Image" className="h-24" />  
                        <p>{stf.first_name} {stf.last_name}
                            <br />{stf.role}
                            </p> 

                        
                    </div>
                )
                :

          
        []

            }
          


          </div>

        </div>
    )

}
export default Staff