<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Donate with PayPal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">



    @vite('resources/css/app.css')
    <!-- <title>Donate with PayPal</title> -->

</head>
<body class="bg-white-300">
<div class="max-w-sm rounded overflow-hidden shadow-lg m-auto  mt-10  fill-gray-600" >
<div class="bg-blue-400 px-4 py-8 text-lg font-semibold text-white-800 ">
<h3  class=" flex items-center  justify-center  text-xl font-bold text-white">Your Gift goes Twice as far</h3>

    </div>
    <!-- <h4 class="text-black  flex items-left">Select a donation amount 

<span><i class="fa-solid fa-lock  text-orange-400" ></i></span>
</h4> -->
    <!-- @csrf -->
    <input type="number" id="donationAmount" placeholder="Enter custom amount"  class="border border-gray-300 p-2 m-2  ml-16 outline-solid" >
    <!-- <button type="Submit" id="paypal-button" >Submit</button> -->
     <p id="item"></p>
<div class="flex items-center justify-center  bg-white-300 grid grid-cols-3 gap-3">

<button class="flex items-center gap-2 bg-gray-200 hover:bg-orange-400 text-black font-bold py-2 px-4 m-4 " onclick="paymentValue()">
  <i class="fa-solid fa-dollar-sign"></i>
  <span>20</span>
</button>
<button class="flex items-center gap-2 bg-gray-200 hover:bg-orange-400 text-black font-bold py-2 px-4 m-4 " onclick="paymentValue()">
  <i class="fa-solid fa-dollar-sign"></i>
  <span>50</span>
</button>
<button class="flex items-center gap-2 bg-gray-200 hover:bg-orange-400 text-black font-bold py-2 px-4 m-4 " onclick="paymentValue()">
  <i class="fa-solid fa-dollar-sign"></i>
  <span>100</span>
</button>


</div>




<div class="flex items-center justify-center  bg-white-300 grid grid-cols-3 gap-3">


   
<button class="flex items-center gap-2 bg-gray-200 hover:bg-orange-400 text-black font-bold py-2 px-4 m-4 " onclick="paymentValue()">
  <i class="fa-solid fa-dollar-sign"></i>
  <span>500</span>
</button>

<button class="flex items-center gap-2 bg-gray-200 hover:bg-orange-400 text-black font-bold py-2 px-4 m-4 " onclick="paymentValue()">
  <i class="fa-solid fa-dollar-sign"></i>
  <span>1000</span>
</button>

<button class="flex items-center gap-2 bg-gray-200 hover:bg-orange-400 text-black font-bold py-2 px-4 m-4 " onclick="paymentValue()">
  <i class="fa-solid fa-dollar-sign"></i>
  <span>10</span>
</button>
</div>




<div class="flex items-center justify-center  bg-white-300 grid grid-cols-3 gap-3">


   
<button class="payment-item  flex items-center gap-2 bg-gray-200 hover:bg-orange-400 text-black font-bold py-2 px-4 m-4 rounded-full " onclick="paymentItem()">
  Food
</button>

<button class="payment-item flex items-center gap-2 bg-gray-200 hover:bg-orange-400 text-black font-bold py-2 px-4 m-4 rounded-full" onclick="paymentItem()">
 
  Fee
</button>

<button class="payment-item  flex items-center gap-2 bg-gray-200 hover:bg-orange-400 text-black font-bold w-24 px-4 m-4 rounded-full" onclick="paymentItem()">
 Class rooms
</button>
</div>


<div class="flex items-center justify-center  bg-white-300 grid grid-cols-3 gap-3">


   
<button class="payment-item flex items-center gap-2 bg-gray-200 hover:bg-orange-400 text-black font-bold w-28 px-4 m-4 rounded-full " onclick="paymentItem()">
  School trip
</button>

<button class="payment-item        flex items-center gap-2 bg-gray-200 hover:bg-orange-400 text-black font-bold w-28 px-4  m-4  rounded-full" onclick="paymentItem()">
 
  School van
</button>

<button class="payment-item        flex items-center gap-2 bg-gray-200 hover:bg-orange-400 text-black font-bold py-2 px-4 m-4 rounded-full" onclick="paymentItem()">
 Uniform
</button>
</div>





<div id= "paypal-button-container">


</div>

</div>

<script>

function paymentValue() {
    const amount = document.getElementById('donationAmount')
    amount.value = event.target.innerText
    console.log(amount.value);
}
function paymentItem () {
    const item = document.getElementById('item')
    item.value = event.target.textContent
    const buttons = document.querySelectorAll(".payment-item");
    buttons.forEach(element => {
        element.classList.remove("bg-orange-400");
    });
    event.target.classList.add("bg-orange-400");

}

</script>

<!-- <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.key') }}&currency=USD"></script>


<script>
    console.log(paypal)
</script> -->

<script
            src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.key') }}&buyer-country=US&currency=USD&components=buttons&enable-funding=venmo,paylater,card"
            data-sdk-integration-source="developer-studio"
        ></script>
<!-- <script>
    console.log()
</script> -->
<script>


document.addEventListener("DOMContentLoaded", function () {




    
        paypal.
        Buttons({
            style: {
            shape: "rect",
            layout: "vertical",
            color: "blue",
            label: "",
            
        
        },


            createOrder: async function (data, actions ) {
                //get amount input 
                const amount = document.getElementById('donationAmount').value
                // console.log(amount)
                return await fetch("{{ route('make.payment') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

                },
                body: JSON.stringify({ amount: amount , item: document.getElementById('item').value })
                    })
                    .then(response => response.json())
                    .then(order => order.id)
                    .catch( err=> console.log(err));
        
            },
            onApprove : async function (data, actions) {
                // console.log(data.orderID)
            return await fetch("{{ route('success.payment') }}", {
                method : 'POST',
                headers : {
                    "Content-Type" : "application/json",
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

                },
                body : JSON.stringify({ order_id : data.orderID , item: document.getElementById('item').value})
            })
            .then(response=> response.json())
            .then(details => {
                if (details.status === "INSTRUMENT_DECLINED") {
                    alert("Payment failed!");


                    } else {
                        window.location.replace("{{ route('success') }}");
                    }
            })


            },
            onCancel : function (data) {
                window.location.replace("{{ route('cancel') }}");
            }


        }).render("#paypal-button-container")
        .then(() => console.log("PayPal button rendered successfully!"))
        .catch((err) => console.error("PayPal button failed to render:", err));
    })
</script> 
</body>
</html>

<!-- make database table for tracking payment , no need for users to login. -->