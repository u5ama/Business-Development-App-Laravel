<?php

return
    [
        // Google NTB Api key Credentials

        'Google_Key' => 'AIzaSyDIPbhytGCc5Oc6u41jD3n25AeVTfDXezM',

        // Google Netblaze Api key Credentials

        'googleApi' => 'AIzaSyDIPbhytGCc5Oc6u41jD3n25AeVTfDXezM',

        // Google Analytics  CallBack

        'CallBack' => 'http://app.trustyy.io/google-analytics/callback',  //for dev
        //'CallBack' => 'http://localhost/projects/madison-api/google-analytics/callback',  //for local


        // Buzzsumo Netblaze Api Credentials

        'BUZZSUMO_API_KEY' =>'GQSHc3bJJY2NpbgHKrdPWR0gAEW9E5L4',

        // Facebook Netblaze Api key Credentials

        // 'FACEBOOK_APP_ID' => '395729387633825',
        //  'FACEBOOK_APP_SECRET' => '52683a93bba3dbe0d249c78941eb2072',


        'FACEBOOK_APP_ID' => '849551648879382',
        'FACEBOOK_APP_SECRET' => '97b71e513a40d6ec2f77c04633e22743',


//        'FACEBOOK_APP_ID' => '1942980529289838',
//        'FACEBOOK_APP_SECRET' => '54c688820f6a4e66c585d4ea32c2bf60',

        //  Facebook Development Netblaze App Credentials
        'Test_FACEBOOK_APP_ID' => '395729387633825',
        'Test_FACEBOOK_APP_SECRET' => '52683a93bba3dbe0d249c78941eb2072',

        // Brightlocal Netblaze Api key Credentials

        'BrightLocal_key' => '752192015e5b34fdd5f330121d17701573548176',
        'BrightLocal_secret' => '5b6d5eabf0174',

        //Amember Api Key

        'AMEMBER_APP_KEY' => '9d9mlfiUm1I57GMlGqIm',


        //Aweber Credentials

        'AWEBER_CONSUMER_KEY' => 'Ak5hQjTMik74ehDwk34StNLD',

        'AWEBER_CONSUMER_SECRET' => 'y9Rwigej89qjGT37wY5xQGvw2lYh6cx2qccKZGP9',


        'AWEBER_ACCESS_TOKEN_KEY' => 'AgJ85WOjcLrGYs8s9h3cZOyv',

        'AWEBER_ACCESS_TOKEN_SECRET' => 'Wqhh4W10k4BJ7SYHrbamzHgr89PYhBSZnVmLUtnH',

        'APP_ENV' => 'development', // 'local', 'development', 'UAT', 'production'

        // stripe

        'STRIPE_KEY' => env('STRIPE_KEY'),

        'STRIPE_SECRET' => env('STRIPE_SECRET'),

        // twilio
        'TWILIO_SID' => env('TWILIO_SID'),

        'TWILIO_TOKEN' => env('TWILIO_TOKEN'),

        'TWILIO_FROM' => env('TWILIO_FROM'),

    ];
