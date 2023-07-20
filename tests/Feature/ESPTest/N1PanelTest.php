<?php

namespace ESPTest;

use App\Facades\CashSMM;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class N1PanelTest extends TestCase
{
    use RefreshDatabase;

    private $order;

    public function getProvider()
    {
        return [
            "url" => 'https://n1panel.com/api/v2',
            "api_key" => env('N1PANEL_API_KEY')
        ];
    }

    public function getOrder()
    {
        $this->order = [
            "service" => 2976,
            "link" => "0000",
            "quantity" => 100,
            "id"=> 190
        ];
        return $this->order;
    }

    public function testGetServices()
    {
        $servicesResponse = app()->make('n1panel')
            ->setProvider($this->getProvider())
            ->getServices();
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('service', $servicesResponse[0]);
    }

    public function testCreateOrder()
    {
        $orderResponse = app()->make('n1panel')
            ->setProvider($this->getProvider())
            ->setOrder($this->getOrder())
            ->placeOrder();
        $this->assertIsArray($orderResponse);
        $this->assertArrayHasKey('reference', $orderResponse);
        $this->assertEquals('true' ,$orderResponse['is_success']);
    }

    public function testGetOrderStatus()
    {
        $servicesResponse = app()->make('n1panel')
            ->setProvider($this->getProvider())
            ->getOrderStatus('726','4385843');
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('status', $servicesResponse);
    }

    public function testGetBalance()
    {
        $servicesResponse = app()->make('n1panel')
            ->setProvider($this->getProvider())
            ->getUserBalance();
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('balance', $servicesResponse);
    }
}
