import React, { useEffect } from "react";
import donationImage from "../../../public/assets/rect131.png";
import ParentLayout from "./ParentLayout";

import axios from "axios";
const PaypalScreen = () => {
  const [csrfToken, setcsrfToken] = React.useState("");
  const [amount, setAmount] = React.useState(0);

  useEffect(() => {
    axios.get("/csrf-token").then((response) => {
      console.log("CSRF cookie set:", response);
      setcsrfToken(response.data.token);
      console.log(">>>>>>>>>CSRF Token:", response.data.token);
    });
  }, []);
  useEffect(() => {
    const paypalScript = document.createElement("script");
    paypalScript.src = `https://www.paypal.com/sdk/js?client-id=${ import.meta.env.VITE_CLIENT_ID}&currency=USD&components=buttons&enable-funding=venmo,paylater,card`;
    paypalScript.async = true;
    paypalScript.onload = () => {
      window.paypal
        .Buttons({
          style: {
            shape: "rect",
            layout: "vertical",
            color: "blue",
            label: "",
          },
          createOrder:  function () {
            // Get the amount from the input field
            let amount = document.getElementById("donationAmount").value;
            
            console.log("Amount to be paid :", amount);
            if (!amount || isNaN(amount) || amount <= 0) {
              alert("Please enter a valid amount.");
              return;
            }
            return axios.post("/handle-payment", {
              headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
              },
              amount: amount ,
            })
              .then((response) => response.data)
              .then((order) => order.id)
              .catch((err) => console.log(err));
          },
          onApprove:  function (data) {
            return axios.post("/success-payment", {
              headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
              },
              order_id: data.orderID ,
            })
              .then((response) => response.data)
              .then((details) => {
                if (details.status === "INSTRUMENT_DECLINED") {
                  alert("Payment failed!");
                } else {
                  window.location.replace("/success");
                }
              });
          },
          onCancel: function () {
            window.location.replace("/cancel");
          },
        })
        .render("#paypal-button-container");
    };
    document.body.appendChild(paypalScript);
  }, []);

  const handlePaymentValue = (value) => {
    let inputField = document.getElementById("donationAmount").value = value;
    
  
    
    setAmount(value);
    // console.log("Selected amount:",);
    // inputField.value = value; // Set the input field value to the selected amount
  };

  return (
    //  className="h-120 mt-20 px-32 max-w-7xl "
    <div className="bg-white-300" >
      <ParentLayout>
            <div style={{ backgroundImage: `url(${donationImage})` }} className="h-120 -mt-12 px-32 ml-32 max-w-7xl " ></div>

      <div className="max-w-sm rounded overflow-hidden shadow-lg -mt-20  py-10 ml-48  fill-gray-600">

        <div className="bg-blue-400 px-4 py-8 text-lg font-semibold text-white-800">
          <h3 className="flex  items-center justify-center text-xl font-bold text-white">
            Your Gift goes Twice as far
          </h3>
        </div>
        <input
          type="number"
          id="donationAmount"
          placeholder="Enter custom amount"
          className="border border-gray-300 p-2 m-2 ml-16 outline-solid"
        />
        <div className="flex items-center justify-center bg-white-300 grid grid-cols-3 gap-3">
          {[20, 50, 100, 500, 1000, 10].map((amount) => (
            <button
              key={amount}
              className="flex items-center gap-2 bg-gray-200 hover:bg-orange-400 text-black font-bold py-2 px-4 m-4"
              onClick={() => handlePaymentValue(amount)}
            >
              <i className="fa-solid fa-dollar-sign"></i>
              <span>{amount}</span>
            </button>
          ))}
        </div>
        <div id="paypal-button-container"></div>
      </div>
      </ParentLayout>
    </div>
  );
};
export default PaypalScreen;