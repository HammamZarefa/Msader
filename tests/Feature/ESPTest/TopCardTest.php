<?php

namespace ESPTest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TopCardTest extends TestCase
{
    use RefreshDatabase;

    private $order;

    public function getProvider()
    {
        return [
            "url" => 'http://api.top4card.com/client/api',
            "api_key" => env('TOP4CARD_API_KEY')
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
        $servicesResponse = app()->make('topcard')
            ->setProvider($this->getProvider())
            ->getServices();
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('service', $servicesResponse[0]);
    }

    public function testCreateOrder()
    {
        $orderResponse = app()->make('topcard')
            ->setProvider($this->getProvider())
            ->setOrder($this->getOrder())
            ->placeOrder();
        $this->assertIsArray($orderResponse);
        $this->assertArrayHasKey('reference', $orderResponse);
        $this->assertEquals('true' ,$orderResponse['is_success']);
    }

    public function testGetOrderStatus()
    {
        $servicesResponse = app()->make('topcard')
            ->setProvider($this->getProvider())
            ->getOrderStatus('726','108248');
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('status', $servicesResponse);
    }

    public function testGetBalance()
    {
        $servicesResponse = app()->make('topcard')
            ->setProvider($this->getProvider())
            ->getUserBalance();
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('balance', $servicesResponse);
    }

}
