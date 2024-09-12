<?php

return[ 


    /*--------------esewa data start-----------------*/

    // 'esewa_pay_url' => "https://rc-epay.esewa.com.np/api/epay/main/v2/form",//test
    'esewa_pay_url' => "https://epay.esewa.com.np/api/epay/main/v2/form ",//live

    // 'esewa_verify_url' => "https://uat.esewa.com.np/api/epay/transaction/status",//test
    'esewa_verify_url' => "https://epay.esewa.com.np/api/epay/transaction/status",//live

    // 'esewa_scd' => "EPAYTEST",//test
    'esewa_scd' => "NP-ES-EHEALTH",//live

    // 'esewa_secret_key' => "8gBm/:&EnhH.1/q",//test
    'esewa_secret_key' => "IF1FPwQSBxERRT0AAxYcGQ5ZNQURWUE/HwFDKyNIMjJeLi08JD8xPw==",//live

    /*--------------esewa data end-----------------*/


    /*--------------fonepay data start-----------------*/

    // 'fonepay_pay_url'     =>  "https://dev-clientapi.fonepay.com/api/merchantRequest",//test
    'fonepay_pay_url'     =>  "https://clientapi.fonepay.com/api/merchantRequest",//live

    // 'fonepay_verify_url'     =>  "https://dev-clientapi.fonepay.com/api/merchantRequest/verificationMerchant",//test
    'fonepay_verify_url'     =>  "https://clientapi.fonepay.com/api/merchantRequest/verificationMerchant",//live

    // 'fonepay_secret_key'   =>  "a7e3512f5032480a83137793cb2021dc",//test
    'fonepay_secret_key'   =>  "ad191bf9ccc5427f92b4b9861bd519ed",//live

    // 'fonepay_pid'    =>  "NBQM",//test
    'fonepay_pid'    =>  "2222160015775208",//live
    
    /*--------------fonepay data end-----------------*/


    // 'nepal_pay' => [
    //     'inst_url' => 'https://apisandbox.nepalpayment.com/GetPaymentInstrumentDetails',
    //     'process_url' => 'https://apisandbox.nepalpayment.com/GetProcessId',
    //     'redirect_url' => 'https://gatewaysandbox.nepalpayment.com/Payment/Index',
    //     'status_url' => 'https://apisandbox.nepalpayment.com/CheckTransactionStatus',
    //     'merchantId' => '7386',
    //     'mercahntName' => 'ehealthapi',
    //     'apiUser' => 'ehealthapi',
    //     'apiPass' => 'D_@#R278332a8',
    //     'secret' => 'key27dbsab928eqodmc7',

    // ],

    'nepal_pay' => [
        'inst_url' => 'https://apigateway.nepalpayment.com/GetPaymentInstrumentDetails',
        'process_url' => 'https://apigateway.nepalpayment.com/GetProcessId',
        'redirect_url' => 'https://gateway.nepalpayment.com/payment/index',
        'status_url' => 'https://apigateway.nepalpayment.com/CheckTransactionStatus',
        'merchantId' => '327',
        'mercahntName' => 'ehealthapi',
        'apiUser' => 'ehealthapi',
        'apiPass' => 'EhE@!Th4169',
        'secret' => '#hE@lth87912',
    ],

    /*--------------khalti data start-----------------*/

    // 'khalti_verify_url'     =>  "https://khalti.com/api/v2/payment/verify/",

    // 'khalti_secret_key'   =>  "test_secret_key_ac3b9ea5852c45d597d141b28d2c7c44",

    // 'khalti_public_key'    =>  "test_public_key_bc744f8267dc4775a38af37cab5591d0",
    
    /*--------------khalti data end-----------------*/

];