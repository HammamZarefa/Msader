<?php

namespace ESPTest;

use App\Facades\CashSMM;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FasterSMMTest extends TestCase
{
    use RefreshDatabase;

    private $order;

    public function getProvider()
    {
        return [
            "url" => 'https://fastersmm.com/api/v2',
            "api_key" => env('FASTERSMM_API_KEY')
        ];
    }

    public function getOrder()
    {
        $this->order = [
            "service" => 6764 ,
            "link" => "0000",
            "quantity" => 10,
            "id"=> 190
        ];
        return $this->order;
    }

    public function testGetServices()
    {
        $servicesResponse = app()->make('fastersmm')
            ->setProvider($this->getProvider())
            ->getServices();
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('service', $servicesResponse[0]);
    }

    public function testCreateOrder()
    {
        $orderResponse = app()->make('fastersmm')
            ->setProvider($this->getProvider())
            ->setOrder($this->getOrder())
            ->placeOrder();
        $this->assertIsArray($orderResponse);
        $this->assertArrayHasKey('reference', $orderResponse);
        $this->assertEquals('true' ,$orderResponse['is_success']);
    }

    public function testGetOrderStatus()
    {
        $servicesResponse = app()->make('fastersmm')
            ->setProvider($this->getProvider())
            ->getOrderStatus('726','1753902');
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('status', $servicesResponse);
    }

    public function testGetBalance()
    {
        $servicesResponse = app()->make('fastersmm')
            ->setProvider($this->getProvider())
            ->getUserBalance();
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('balance', $servicesResponse);
    }
}
