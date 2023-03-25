<?php

namespace Tests\Feature\ProviderHelper;

use App\Helper\ProviderHelper\Provider\SmsActivate\AbstractSmsActivateOperation;
use App\Helper\ProviderHelper\Provider\SmsActivate\SmsActivate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SmsActivateTest extends TestCase
{

    public function getProvider()
    {
        return [
            "url" => 'https://api.sms-activate.org/stubs/handler_api.php',
            "apikey" => "9bf3A070f4f61e36565e13c106e7e293"
        ];
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetUserBalance()
    {
        $response = (new \App\Helper\ProviderHelper\Provider\SmsActivate\SmsActivate)->setProvider($this->getProvider())->getUserBalance();
        dd($response);
    }
}
