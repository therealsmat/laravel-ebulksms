<?php 

return [

    /**
     * Your login username on eBulkSMS (same as your email address)
     */
    'username'          => getenv('EBULK_USERNAME'),

    /**
     * Your Ebulk SMS Api Key
     */
    'apiKey'            => getenv('EBULK_API_KEY'),

    /**
     * Your chosen sender name
     */
    'sender'            => getenv('EBULK_SENDER_NAME'),

    /**
     * Country code to be appended to each phone number
     */
    'country_code'      => '234'
];