<?php

namespace Tests\Feature\ESPTest;

use App\Facades\SmsActivate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SmsActivateTest extends TestCase
{
    use RefreshDatabase;
    public function getProvider()
    {
        return [
            "url" => 'https://api.sms-activate.org/stubs/handler_api.php',
            "api_key" => env('SMSACTIVATE_API_KEY')
        ];
    }

    public function testGetBalance()
    {
        $balanceResponse = app()->make('smsactivate')
            ->setProvider($this->getProvider())
            ->getUserBalance();
        $this->assertIsArray($balanceResponse);
        $this->assertNotNull($balanceResponse['balance']);
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
