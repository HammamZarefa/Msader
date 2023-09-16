<?php

namespace ESPTest;

use App\Facades\XpCard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SawaCardTest extends TestCase
{
    use RefreshDatabase;

    private $order;

    public function getProvider()
    {
        return [
            "url" => 'http://api.sawa5card.com/client/api',
            "api_key" => env('SAWACARD_API_KEY')
        ];
    }

    public function getOrder()
    {
        $this->order = [
            "service" => 320,
            "link" => "0000",
            "quantity" => 1,
            "id"=> 190,
            "playername" => "0"
        ];
        return $this->order;
    }

    public function testGetServices()
    {
        $servicesResponse = app()->make('sawacard')
            ->setProvider($this->getProvider())
            ->getServices();
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('service', $servicesResponse[0]);
    }

    public function testCreateOrder()
    {
        $orderResponse = app()->make('sawacard')
            ->setProvider($this->getProvider())
            ->setOrder($this->getOrder())
            ->placeOrder();
        $this->assertIsArray($orderResponse);
        $this->assertArrayHasKey('reference', $orderResponse);
        $this->assertEquals('true' ,$orderResponse['is_success']);
    }

    public function testGetOrderStatus()
    {
        $servicesResponse = app()->make('sawacard')
            ->setProvider($this->getProvider())
            ->getOrderStatus('726','108248');
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('status', $servicesResponse);
    }

    public function testGetBalance()
    {
        $servicesResponse = app()->make('sawacard')
            ->setProvider($this->getProvider())
            ->getUserBalance();
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('balance', $servicesResponse);
    }

}
