<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Donate with PayPal</title>
    <!-- <title>Donate with PayPal</title> -->

</head>
<body>

<h2>Donate with PayPal</h2>

    <!-- @csrf -->
    <input type="number" id="donationAmount" placeholder="Enter amount" value="10">
    <!-- <button type="Submit" id="paypal-button" >Submit</button> -->



<div id= "paypal-button-container">


</div>

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
            color: "gold",
            label: "paypal",
        
        },
        message: {
            amount: 100,
        } ,

            createOrder: async function (data, actions ) {
                //get amount input 
                const amount = document.getElementById('donationAmount').value
                // console.log(amount)
                return await fetch("{{ route('make.payment') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')

                    // "XCSRF-TOKEN" :" {{ csrf_token() }}",
                    // "Cross-Origin-Opener-Policy": "same-origin-allow-popups"
                },
                body: JSON.stringify({ amount: amount })
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
                body : JSON.stringify({ order_id : data.orderID })
            })
            .then(response=> response.json())
            .then(details => {
                if (details.status === "INSTRUMENT_DECLINED") {
                    alert("Payment failed!");


                    } else {
                        // return await fetch("{{ route('success') }} ",{
                        //     method: "GET",

                        // }).then(response => response.json())
                        // .then(data => {
                        //     console.log(data)
                        // })
                        console.log(details);
                    }
            })


            }
        }).render("#paypal-button-container")
        .then(() => console.log("PayPal button rendered successfully!"))
        .catch((err) => console.error("PayPal button failed to render:", err));
    })
</script> 
</body>
</html>

<!-- make database table for tracking payment , no need for users to login. -->