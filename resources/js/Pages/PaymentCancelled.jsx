
import React from "react";
import ParentLayout from "./ParentLayout";
const PaymentCancelled = () => {

    return (
        <ParentLayout>
        <div className="max-w-md rounded overflow-hidden shadow-lg h-96">
  <div className=" py-4  items-center">
    <div className="font-bold text-xl mb-2">Payment Status</div>
    <p className="text-red-500 text-base ">
    Payment has been declined
    </p>
  </div>
 
</div>
</ParentLayout>
    )

}
export default PaymentCancelled;