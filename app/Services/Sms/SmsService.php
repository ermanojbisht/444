<?php

namespace App\Services\Sms;

use App\Models\User;
use GuzzleHttp\Client;

class SmsService implements SmsInterface
{
    protected string $url, $apiKey, $senderId;

    function __construct($url, $apiKey, $senderId)
    {
        $this->url = $url;
        $this->apiKey = $apiKey;
        $this->senderId = $senderId;
    }

    public function sendMsgToUser(User $user, $message, $templateId)
    {
        if ($user->contact_no) {
            $this->sendMsg($user->contact_no, $message, $templateId);
        }
    }

    public function sendMsg($phone_number, $message, $templateId)
    {
        $client = new Client();
        $data = [
            'Account' => [
                'APIkey' => $this->apiKey,
                'SenderId' => $this->senderId,
                'Channel' => '2',
                'DCS' => '0',
                'SchedTime' => null,
                'GroupId' => null,
                'EntityId' => ''
            ],
            'Messages' => [
                [
                    'Text' => $message,
                    'DLTTemplateId' => $templateId,
                    'Number' => $phone_number
                ]
            ]
        ];
        $response = $client->post($this->url, ['form_params' => $data], ['Content-Type' => 'application/json']);
        //Log::info("response = ".print_r($response,true));
        $responseJSON = json_decode($response->getBody(), true);
        dd($responseJSON);


    }
}
