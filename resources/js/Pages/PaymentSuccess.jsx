
import React from "react";
import ParentLayout from "./ParentLayout";
const PaymentSuccess = () => {

    return (
        <ParentLayout>
        <div className="max-w-md rounded overflow-hidden shadow-lg h-96">
  <div className="px-6 py-4  items-center">
    <div className="font-bold text-xl mb-2">Payment Status</div>
    <p className="text-lime-500 text-base ">
    Payment has been completed successfully
    </p>
  </div>
 
</div>
</ParentLayout>
    )

}
export default PaymentSuccess;