<?php
namespace App\Service;
use Twilio\Rest\Client;

class SmsGenerator{

    public function SendSms(string $number,string $name,string $text){
       /* $accountSid=$_ENV['AC5fb7eafee484e20be7d0a361ea313837'];
        $authToken=$_ENV['ff62af8896dba985008e891fba7891ff'];
        $fromNumber=$_ENV['+13203851117'];*/
        $accountSid = $_ENV['TWILIO_ACCOUNT_SID'];
        $authToken = $_ENV['TWILIO_AUTH_TOKEN'];
        $fromNumber = $_ENV['TWILIO_FROM_NUMBER'];
        $toNumber= $number;
        $message=''.$name.'vous a envoyer le message suivant:'.' '.$text.'';
        $client=new Client($accountSid,$authToken);
        $client->messages->create(
            $toNumber,
            [
                'from'=>$fromNumber,
                'body'=>$message,
            ]
        );
    }
}