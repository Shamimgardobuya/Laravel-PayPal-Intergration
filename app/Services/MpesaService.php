<?php
namespace App\Services;

use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

use function Laravel\Prompts\error;

class MpesaService
{  

   private $token;
   private $username;
   private $password;
   private $callback_url;
   private $validate_url;
   private $mpesa_domain;

   public function __construct() {
    $this->username = config('mpesa.username');
    $this->password = config('mpesa.password');
    $this->callback_url = config('mpesa.callback_url');
    $this->validate_url = config("mpesa.validate_url");
    $this->mpesa_domain = config('app.env') == 'production' ?
                        "https://production.safaricom.co.ke":
                        "https://sandbox.safaricom.co.ke" ;

}

public function get_authorization_token() {
    try {
        $generate_token_for_header = base64_encode($this->username.':'.$this->password);
        $base_url  = "{$this->mpesa_domain}/oauth/v1/generate?grant_type=client_credentials";

        $response = Http::withHeader(
            'Authorization', 'Basic '.$generate_token_for_header
            )
                                ->get($base_url)
                                ->throw()
                                ->json();
        $this->token =  $response['access_token'];
        return $this->token;
    } catch (\Throwable $th) {
        $message = $th->getMessage();
        $error = strtok($message, "\n");
        return  $error;

    }
}
    public function register_url() {
    $payload =  ["ShortCode"=> config('mpesa.short_code_register'),
                "ResponseType"=> "Completed",
                "ConfirmationURL"=> $this->callback_url,
                "ValidationURL"=> $this->validate_url
    ];
    try {
        $response = Http::withHeader(
                    'Authorization', 'Bearer '.$this->token
                )->post("{$this->mpesa_domain}/mpesa/c2b/v1/registerurl", $payload)
                ->throw()
                ->json();

    return $response;
    } catch (\Throwable $th) {
        $message = $th->getMessage();
        $error = strtok($message, "\n");
        return  $error;
    }

    

}
   public function process_request($phone_number, $amount){
    $formatted_phone = preg_replace('/^0/', '254', $phone_number);
    $payload = [
        "BusinessShortCode"=> config('mpesa.short_code'),
        "Password"=> base64_encode(config('mpesa.short_code').config('mpesa.passkey').date("YmdHis")),
        "Timestamp"=> date("YmdHis"),
        "TransactionType"=> "CustomerPayBillOnline",
        "Amount"=> $amount,
        "PartyA"=> $formatted_phone,
        "PartyB"=> config('mpesa.short_code') ,
        "PhoneNumber"=> $formatted_phone,
        "CallBackURL"=> $this->callback_url,
        "AccountReference"=> config("mpesa.account_ref"),
        "TransactionDesc" => "Lillions_dons"
    ];
    try {
        $response = Http::withHeader(
                    'Authorization', 'Bearer '.$this->token
                )->post("{$this->mpesa_domain}/mpesa/stkpush/v1/processrequest", $payload)
                ->throw()
                ->json();

        return $response;
    } catch (\Throwable $th) {
        $message = $th->getMessage();
        $error = strtok($message, "\n");
        return  $error;

    }
    
   }

}