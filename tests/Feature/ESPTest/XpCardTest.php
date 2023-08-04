<?php

namespace ESPTest;

use App\Facades\XpCard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class XpCardTest extends TestCase
{
    use RefreshDatabase;

    private $order;

    public function getProvider()
    {
        return [
            "url" => 'https://xp-card.com/api',
            "api_key" => env('XPCARD_API_KEY')
        ];
    }

    public function getOrder()
    {
        $this->order = [
            "service" => 21,
            "link" => "0000",
            "quantity" => 1,
            "id"=> 190,
            "playername" => "0"
        ];
        return $this->order;
    }

    public function testGetServices()
    {
        $servicesResponse = app()->make('xpcard')
            ->setProvider($this->getProvider())
            ->getServices();
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('service', $servicesResponse[0]);
    }

    public function testCreateOrder()
    {
        $orderResponse = app()->make('xpcard')
            ->setProvider($this->getProvider())
            ->setOrder($this->getOrder())
            ->placeOrder();
        $this->assertIsArray($orderResponse);
        $this->assertArrayHasKey('reference', $orderResponse);
        $this->assertEquals('true' ,$orderResponse['is_success']);
    }

    public function testGetOrderStatus()
    {
        $servicesResponse = app()->make('xpcard')
            ->setProvider($this->getProvider())
            ->getOrderStatus('726','00361268');
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('status', $servicesResponse);
    }

}
