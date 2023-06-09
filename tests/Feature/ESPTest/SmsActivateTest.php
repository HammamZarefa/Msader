<?php

namespace Tests\Feature\ESPTest;

use App\Facades\SmsActivate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SmsActivateTest extends TestCase
{

    public function getProvider()
    {
        return [
            "url" => 'https://api.sms-activate.org/stubs/handler_api.php',
            "apikey" => env('SMSACTIVATE_API_KEY')
        ];
    }

    public function testGetBalance()
    {
        $placeOrderResponse = app()->make('smsactivate')
            ->setProvider($this->getProvider())
            ->getUserBalance();
        dd($placeOrderResponse);
        $this->assertUnifiedResponse($placeOrderResponse);
        $this->assertEquals($this->package['track_id'], $placeOrderResponse['track_id']);
    }
    public function testGetOrderStatus()
    {
        $placeOrderResponse = app()->make('smsactivate')
            ->setProvider($this->getProvider())
            ->getOrderStatus();
        dd($placeOrderResponse);
        $this->assertUnifiedResponse($placeOrderResponse);
        $this->assertEquals($this->package['track_id'], $placeOrderResponse['track_id']);
    }
}
