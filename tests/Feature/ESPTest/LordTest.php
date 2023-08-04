<?php

namespace ESPTest;

use App\Facades\Lord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LordTest extends TestCase
{
    use RefreshDatabase;

    private $order;

    public function getProvider()
    {
        return [
            "url" => 'https://lord-telecom.com/api/APIs',
            "api_key" => env('LORD_API_KEY')
        ];
    }

    public function getOrder()
    {
        $this->order = [
            "service" => 63,
            "link" => "0000",
            "quantity" => 100,
            "id"=> 190,
            "playername" => "0"
        ];
        return $this->order;
    }

    public function testGetServices()
    {
        $servicesResponse = app()->make('lord')
            ->setProvider($this->getProvider())
            ->getServices();
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('service', $servicesResponse[0]);
    }

    public function testCreateOrder()
    {
        $orderResponse = app()->make('lord')
            ->setProvider($this->getProvider())
            ->setOrder($this->getOrder())
            ->placeOrder();
        $this->assertIsArray($orderResponse);
        $this->assertArrayHasKey('reference', $orderResponse);
        $this->assertEquals('true' ,$orderResponse['is_success']);
    }

    public function testGetOrderStatus()
    {
        $servicesResponse = app()->make('lord')
            ->setProvider($this->getProvider())
            ->getOrderStatus('726','158013');
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('status', $servicesResponse);
    }

    public function testGetBalance()
    {
        $servicesResponse = app()->make('lord')
            ->setProvider($this->getProvider())
            ->getUserBalance();
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('balance', $servicesResponse);
    }
}
