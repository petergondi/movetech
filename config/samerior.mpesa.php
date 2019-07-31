<?php

return [
    /*
     |------------------------------------------------------
     | Set sandbox mode
     | ------------------------------------------------------
     | Specify whether this is a test app or production app
     | Sandbox base url: https://sandbox.safaricom.co.ke
       Production base url: https://api.safaricom.co.ke
     |
     */
    //'Production base url'=>'https://api.safaricom.co.ke',
    'sandbox' => false,
    /*
   |--------------------------------------------------------------------------
   | Cache credentials
   |--------------------------------------------------------------------------
   |
   | If you decide to cache credentials, they will be kept in your app cache
   | configuration for sometime. Reducing the need for many requests for
   | generating credentials
   |
   */
    'cache_credentials' => true,
    /*
   |--------------------------------------------------------------------------
   | C2B array
   |--------------------------------------------------------------------------
   |
   | If you are accepting payments enter application details and shortcode info
   |
   */
    'c2b' => [
        /*
         * Consumer Key from developer portal
         */
        'consumer_key' => '6pcuMPffphYxuoyskadeSibUKzwowUdj',
        /*
         * Consumer secret from developer portal
         */
        'consumer_secret' => '2hgcoKnS9i1K40hS',
        /*
         * HTTP callback method [POST,GET]
         */
        'callback_method' => 'POST',
        /*
         * Your receiving paybill or till umber
         */
        'short_code' => 400153,
        /*
         * Passkey , requested from mpesa
         */
        'passkey' => '53c4b78a6a03180c4bc923650161b2eea4ceefdd550e91d5341463cc83abbe63',
        /*
         * --------------------------------------------------------------------------------------
         * Callbacks:
         * ---------------------------------------------------------------------------------------
         * Please update your app url in .env file
         * Note: This package has already routes for handling this callback.
         * You should leave this values as they are unless you know what you are doing
         */
        /*
         * Stk callback URL
         */
        'stk_callback' => env('APP_URL') . '/payments/callbacks/stk_callback',
        /*
         * Data is sent to this URL for successful payment
         */
        'confirmation_url' => env('APP_URL') . '/payments/callbacks/confirmation',
        /*
         * Mpesa validation URL.
         * NOTE: You need to email MPESA to enable validation
         */
        'validation_url' => env('APP_URL') . '/payments/callbacks/validate',
    ],
    /*
      |--------------------------------------------------------------------------
      | B2C array
      |--------------------------------------------------------------------------
      |
      | If you are sending payments to customers or b2b
      |
      */
    'b2c' => [
        /*
         * Sending app consumer key
         */
        'consumer_key' => 'Ei4lr5xbDZXS9XEAZ1BhNE4xCBcAYGVyA',
        /*
         * Sending app consumer secret
         */
        'consumer_secret' => 'eMhCDmzFQyx1SNSZ',
        /*
         * Shortcode sending funds
         */
        'short_code' => 600000,
        /*
        * This is the user initiating the transaction, usually from the Mpesa organization portal
        * Make sure this was the user who was used to 'GO LIVE'
        * https://org.ke.m-pesa.com/
        */
        'initiator' => 'testapi',
        /*
         * The user security credential.
         * Go to https://developer.safaricom.co.ke/test_credentials and paste your initiator password to generate
         * security credential
         */
        'security_credential' => 'GXiVXirQFaJvEFOQyn+VJ4Gp3Ccvpoq6aqzFiNgvH18UMU59Qxc+UTAX7Blzo6L0+tQG2wUJ1fKH4YlPagtzDHT37796uu0NysS85uPjxZMjnbGhPNeHnhJLzwyrjppl8mZpnmVg4CaVrEdcriuyifKIiF1hmc0A/RnjBMzY6yevbIV0kAgrn5cDvCN99O1rr1nl69GaVbP7a/6AWnRkVUldnalQmqQhfgLbOdxjGOVGU2arqjuvgQ6glo1uK9PUnp3UH2Vv66Lu99JglWyjlcWufZhJXUmFFB9tfoKAX2URnPGi4PvvJ6OgJNdsJmTsevnG2c/KKOa45rzdvwrwKA==',
       /*
        * Notification URL for timeout
        */
        'timeout_url' => env('APP_URL') . '/payments/callbacks/timeout/',
        /**
         * Result URL
         */
        'result_url' => env('APP_URL') . '/payments/callbacks/result/',
    ],
    /*
     * Configure slack notifications to receive mpesa events and callbacks
     */
    'notifications' => [
        /*
         * Slack webhook URL
         * https://my.slack.com/services/new/incoming-webhook/
         */
        'slack_web_hook' => 'https://hooks.slack.com/services/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',
        /*
         * Get only important notifications
         * You wont be notified for failed stk push transactions
         */
        'only_important' => false,
    ],
];
