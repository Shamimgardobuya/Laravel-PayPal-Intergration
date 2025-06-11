
import React from "react";

import { Inertia } from "@inertiajs/inertia";
import { InertiaLink } from "@inertiajs/inertia-react";
import axios from "axios";
import ParentLayout from "./ParentLayout";
const Values = () => {
  const handleClick = () => {
    Inertia.get("/paypal");
  };

const api_url = import.meta.env.VITE_APP_URL

  return (
    <div className="container mx-auto p-4 h-136 mb-8 py-24 flex flex-col items-center">
      <h1 className="text-2xl font-bold mb-4 text-center">Our Core Values</h1>
      <div className="flex flex-col space-y-16 items-center">
        <div className="flex justify-center space-x-24">
          <div className="flex flex-col items-center">
            <div className="flex items-end space-x-4">
              <img
                src={`${api_url ? api_url.concat("/assets/Sincerity.png") : "none"}`}
                className="h-40"
                alt="Sincerity"
              />
              <label className="text-xl mb-2">Sincerity</label>
            </div>
          </div>
          <div className="flex flex-col items-center">
            <div className="flex items-end space-x-4">
              <img
                src={`${api_url ? api_url.concat("/assets/Kindness.png") : "none"}`}
                alt="Kindness"
                className="h-40"
              />
              <label className="text-xl mb-2">Kindness</label>
            </div>
          </div>
        </div>
        <div className="flex justify-center space-x-24">
          <div className="flex flex-col items-center">
            <div className="flex items-end space-x-4">
              <img
                src={`${api_url ? api_url.concat("/assets/Dedication.png") : "none"}`}
                alt="Dedication"
                className="h-40"
              />
              <label className="text-xl mb-2">Dedication</label>
            </div>
          </div>
          <div className="flex flex-col items-center">
            <div className="flex items-end space-x-4">
              <img
                src={`${api_url ? api_url.concat("/assets/Respect.png") : "none"}`}
                alt="Respect"
                className="h-40"
              />
              <label className="text-xl mb-2">Respect</label>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
export default Values;