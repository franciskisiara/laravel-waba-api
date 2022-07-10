<?php
namespace App\Library\SMS;

use AfricasTalking\SDK\AfricasTalking;

class AT 
{
    protected $sms;

    public function __construct () 
    {
        $this->sms = (new AfricasTalking  (
            env('AFRICAS_TALKING_USERNAME'), 
            env('AFRICAS_TALKING_API_KEY')
        ))->sms();
    }

    public function send ($recipients) 
    {
        $result = $this->sms->send($recipients);

        // dd($result);
    }
}

// $username = 'YOUR_USERNAME'; // use 'sandbox' for development in the test environment
// $apiKey   = 'YOUR_API_KEY'; // use your sandbox app API key for development in the test environment
// $AT       = new AT($username, $apiKey);

// // Get one of the services
// $sms      = $AT->sms();

// // Use the service
// $result   = $sms->send([
//     'to'      => '+2XXYYYOOO',
//     'message' => 'Hello World!'
// ]);
