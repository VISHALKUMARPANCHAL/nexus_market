<?php
class PayPal_Init
{
    // protected $_includeFile;
    public function __construct()
    {
        // echo "123";
        // $this->autoload();
    }

    public function getApiContext()
    {

        $paypal = new PayPal\Rest\ApiContext(
            new PayPal\Auth\OAuthTokenCredential(
                'AR_JhaUAiykycQjicCy2w_pSy2pfH9Zi5PJcRvEmhCal9Tmam94tOc4a4AYnhYfc8axPwYuWI0ogTnp7',
                'EP_TT29BGk4-BzftAa_k-EmGkHzXZT1fAdN1ZJCx3RG-8yfj7KJKq7XVSe0O7wLEj3_JFziFnwgiSqJm'
            )
        );

        $paypal->setConfig([
            'mode' => 'sandbox', // Change to 'live' in production
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => 'PayPal.log',
            'log.LogLevel' => 'DEBUG'
        ]);
        return $paypal;
    }
}