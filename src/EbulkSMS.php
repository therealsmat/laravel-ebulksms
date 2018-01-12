<?php

namespace therealsmat\Ebulksms;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

class EbulkSMS
{
    /**
     * Your login username on EbulkSMS
     * @var
     */
    protected $username;

    /**
     * Your Ebulk SMS Api key
     * @var
     */
    protected $apiKey;

    /**
     * Your chosen sender name
     * @var
     */
    protected $senderName;

    /**
     * Your country code
     * @var
     */
    protected $countryCode;

    /**
     * The phone numbers to receive the messages
     * @var
     */
    protected $recipients = [];

    /**
     * The actual message to be sent
     * @var
     */
    protected $message;

    /**
     * Instance of Guzzle Client
     * @var
     */
    protected $http;

    /**
     * SMS Endpoint
     * @var string
     */
    protected $endpoint = "http://api.ebulksms.com:8080/sendsms.json";

    /**
     * Balance Endpoint
     * @var string
     */
    protected $balance_endpoint = "http://api.ebulksms.com:8080/balance/";

    /**
     * If message should be flashed or sent
     * @var bool
     */
    private $_flash = false;

    /**
     * Response received from http requests
     * @var
     */
    protected $response;

    /**
     * Delimiter to be used to split phone numbers
     * @var string
     */
    protected $separator = ',';

    /**
     * Allowed Http Methods
     * @var array
     */
    protected $httpMethods = ['GET', 'POST'];

    public function __construct()
    {
        $this->loadConfigData();
        $this->prepareRequest();
        return $this;
    }

    /**
     * Get username, senderName and apiKey
     */
    public function loadConfigData()
    {
        $this->username = Config::get('ebulksms.username');

        $this->senderName = Config::get('ebulksms.sender');

        $this->apiKey = Config::get('ebulksms.apiKey');

        $this->countryCode = Config::get('ebulksms.country_code');
    }

    /**
     * Prepare the Guzzle http client with necessary headers
     */
    public function prepareRequest()
    {
        $this->http = new Client([
            'headers' => [
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json'
            ]
        ]);
    }

    public function fromSender($sender)
    {
        $senderName = trim($sender);

        if (is_null($sender)) throw new \Exception('Sender name is invalid!');

        if (strlen($senderName) > 11) throw new \Exception('Your sender name must be less than or equal to 11 characters');

        $this->senderName = $senderName;
        return $this;
    }

    /**
     * Recipients phone numbers. Split
     * @param $recipients
     * @return $this
     */
    public function addRecipients($recipients)
    {
        $this->recipients = $this->split($recipients);
        $this->appendCountryCode();

        return $this;
    }

    /**
     * Split a string into an array using a delimeter
     * @param $string
     * @return array
     */
    private function split($string)
    {
        return explode($this->separator, $string);
    }

    /**
     * Append country code to the individual numbers
     */
    private function appendCountryCode()
    {
        foreach ($this->recipients as $recipient) {
            $mobileNumber = trim($recipient);

            if (substr($mobileNumber, 0, 1) == '0') {
                $mobileNumber = $this->countryCode . substr($mobileNumber,1);
            } elseif (substr($mobileNumber, 0, 1) == '+') {
                $mobileNumber = substr($mobileNumber, 1);
            }
            $messageId = $this->generateUnique();
            $gsm['gsm'][] = [
                'msidn' => $mobileNumber,
                'msgid' => $messageId
            ];
        }
        $this->recipients = $gsm;
        return $this;
    }

    /**
     * Generate a unique id for the message
     * @return bool|string
     */
    private function generateUnique()
    {
        $uniqueId = uniqid('int_', false);

        return substr($uniqueId, 0, 30);
    }

    /**
     * Pass the message you want to send
     * @param $messageText
     * @return EbulkSMS
     * @internal param bool $flash
     * @internal param $message
     */
    public function composeMessage($messageText)
    {
        $message = [
            'sender'    => $this->senderName,
            'messagetext' => $messageText,
            'flash'     => $this->_flash
        ];
        $this->message = $message;
        return $this;
    }

    /**
     * Perform the actual request
     */
    public function send()
    {
        $request = [ 'SMS' => [
            'auth' => [
                'username' => $this->username,
                'apikey' => $this->apiKey
            ],
            'message'   => $this->message,
            'recipients' => $this->recipients
        ]];
        $this->post($this->endpoint, $request);
        return $this->getResponse();
    }

    /**
     * Send a flash message
     * @return mixed
     */
    public function flash()
    {
        $this->message['flash'] = TRUE;

        return $this->send();
    }

    /**
     * Send an http request and receive a response
     * @param $method
     * @param $url
     * @param $body
     * @return $this
     * @throws \Exception
     */
    private function makeHttpRequest($method, $url, $body)
    {
        if (is_null($method) || !in_array($method, $this->httpMethods)) {
            throw new \Exception('Method ' . $method .' is invalid!');
        }

        $this->response = $this->http->{strtolower($method)}(
            $url,
            ["body" => json_encode($body)]
        );
        return $this;
    }

    /**
     * Make a post request
     * @param $url
     * @param $body
     * @return EbulkSMS
     */
    private function post($url, $body)
    {
        return $this->makeHttpRequest('POST', $url, $body);
    }

    /**
     * Make a get request
     * @param $url
     * @param $body
     * @return EbulkSMS
     */
    private function get($url, $body = [])
    {
        return $this->makeHttpRequest('GET', $url, $body);
    }

    /**
     * Get the response from an http request
     * @return mixed
     */
    public function getResponse()
    {
        return json_decode($this->response->getBody(), true);
    }

    /**
     * Get your account balance
     * @return mixed
     */
    public function getBalance()
    {
        $url = $this->balance_endpoint . $this->username . '/' . $this->apiKey;

        $this->get($url);

        return $this->getResponse();
    }
}