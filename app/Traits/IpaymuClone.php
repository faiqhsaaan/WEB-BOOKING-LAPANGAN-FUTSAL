<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Http;

trait IpaymuClone
{
    protected $va = '0000001219043774';
    protected $api_key = 'SANDBOXB26315C9-F810-423C-8A9E-8F96F93B237B';
    protected $timestamp;

    public function __construct()
    {
        $this->va = config('ipaymu.va');
        $this->api_key = config('ipaymu.api_key');
        $this->timestamp = date('YmdHis');
    }

    public function signature(array|string $body, string $method)
    {
        $jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper($method) . ":{$this->va}:{$requestBody}:{$this->api_key}";
        $signature = hash_hmac('sha256', $stringToSign, $this->api_key);

        return $signature;
    }

    public function redirect_payment($user_id, $total_price, $name,  $phone){
        $url                    = 'https://sandbox.ipaymu.com/api/v2/payment';
        $method                 = 'POST';
        $this->timestamp        = Date('YmdHis');

        $user            = User::findOrFail($user_id); 

        $body['product'][]      = "Customer {$name}";
        $body['qty'][]          = 1;
        $body['price'][]        = $total_price;
        $body['description'][]  = "Booking Lapangan Futsal";

        $body['referenceid']    = "ISN-". 
                                    uniqId(). 
                                        strtoupper( 
                                            str_replace( 
                                            '', 
                                            ':', 
                                            $name
                                            ) );
        $body['returnUrl']      = route('callback.notify');
        $body['notifyUrl']      = route('callback.return');
        $body['cancelUrl']      = route('callback.cancel');

        $body['buyerName']      = $name;
        $body['buyerEmail']     = $user->email;
        $body['buyerPhone']     = $phone;
        $body['feeDirection']   = 'BUYER';

        $signature = $this->signature($body, $method);

        $headers = [
            'Content-Type'      => 'application/json',
            'signature'         => $signature,
            'va'                => $this->va,
            'timestamp'         => $this->timestamp,
        ];

        $data_request           = Http::withHeaders($headers)->post($url, $body);
        $response               = $data_request->object();
        return $response;
    }
}
