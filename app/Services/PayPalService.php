<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;

class PayPalService
{
   /**
    * The above PHP class handles PayPal API integration for creating orders, capturing payments, and
    * showing order details.
    */
    private $clientId;
    private $clientSecret;
    private $apiUrl;

    public function __construct()
    {
        $this->clientId = env('CLIENT_ID');
        $this->clientSecret = env('CLIENT_SECRET');
        $this->apiUrl = env('PAYPAL_MODE') === 'sandbox'
            ? 'https://api-m.sandbox.paypal.com'
            : 'https://api-m.paypal.com';
    }

   /**
    * The function `getAccessToken` sends a POST request to PayPal's API to obtain an access token
    * using client credentials.
    * 
    * @return The `getAccessToken` function is returning the access token obtained from the response of
    * the POST request to the PayPal API endpoint for generating access tokens. The function extracts
    * the 'access_token' value from the JSON response and returns it. If the 'access_token' is not
    * found in the response JSON, it returns `null`.
    */
    public function getAccessToken()
    {
        try {
            $client_identification = base64_encode("$this->clientId:$this->clientSecret");
            $curlCommand = "curl -s --fail  -X POST \"https://api-m.paypal.com/v1/oauth2/token\" \
                -H \"Authorization: Basic $client_identification\" \
                -H \"Content-Type: application/x-www-form-urlencoded\" \
                -d \"grant_type=client_credentials\"";
            
            $response = shell_exec($curlCommand);
            return json_decode($response)->access_token;
        } catch (\Throwable $th) {
            return response()->json(
                ['success'=> false,
                'message' => $th]
            );
        }
    
    }

    /**
     * The function `createOrder` in PHP sends a POST request to create a new order with a specified
     * amount using an access token.
     * 
     * @param amount The `createOrder` function is used to create a new order with a specified amount.
     * The `amount` parameter represents the value of the order in USD currency.
     * 
     * @return The `createOrder` function is returning the JSON response from the API call made to
     * create a new order.
     */
    public function createOrder($amount)
    {
        $access_token = $this->getAccessToken();
        if (!$access_token) {
            return null;
        }
        $response  = Http::withToken($access_token)
                    ->post("{$this->apiUrl}/v2/checkout/orders", [
                        'intent' => 'CAPTURE',
                        'purchase_units' => [[
                            'amount' => [
                                'currency_code' => 'USD',
                                'value' => $amount
                            ],
                        
                        ]],
                    
            
                    ]);
        return $response->json();
    }

   /**
    * The function `capturePayment` captures a payment for a specific order using an access token and
    * returns the response in JSON format.
    * 
    * @param orderId The `orderId` parameter in the `capturePayment` function represents the unique
    * identifier of the order that you want to capture the payment for. This identifier is typically
    * generated when the order is created and is used to track and process the order throughout the
    * payment and fulfillment process.
    * 
    * @return The `capturePayment` function is returning the JSON response from the API call made to
    * capture the payment for the specified order ID.
    */
    public function capturePayment($orderId) {
        $access_token = $this->getAccessToken();
        if (!$access_token) {
            return null;
        }
        
        $response  = Http::withToken($access_token)
                    ->post("{$this->apiUrl}/v2/checkout/orders/$orderId/capture",
                [
                    'application_context' => [
                        'cancel_url' => route('cancel'),
                        'return_url' => route('success')
                    ]]
                
                );
        
        return $response->json();

    }

    public function showOrder($orderId) {
        $access_token = $this->getAccessToken();
        if (!$access_token) {
            return null;
        }
        $response  = Http::withToken($access_token)
                    ->post("{$this->apiUrl}/v2/checkout/orders/:$orderId");

        return $response->json();

    }

    public function store() {
        $access_token = $this->getAccessToken();
        if (!$access_token) {
            return null;
        }
        $response  = Http::withToken($access_token)
                    ->post("{$this->apiUrl}/v2/checkout/orders");

        return $response->json();
    }
}