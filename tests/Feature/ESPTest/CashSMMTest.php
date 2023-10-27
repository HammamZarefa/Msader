<?php

namespace Tests\Feature\ESPTest;

use App\Facades\CashSMM;
use App\ExternalProviders\CashSMM\CreateOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CashSMMTest extends TestCase
{
    use RefreshDatabase;

    private $order;

    public function getProvider()
    {
        return [
            "url" => 'https://cashsmm.com/api/v2',
            "api_key" => env('CACHSMM_API_KEY')
        ];
    }

    public function getOrder()
    {
        $this->order = [
            "service" => 6046,
            "link" => "0000",
            "quantity" => 100,
            "id"=> 190
        ];
        return $this->order;
    }

    public function testGetServices()
    {
        $servicesResponse = app()->make('cashsmm')
            ->setProvider($this->getProvider())
            ->getServices();
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('service', $servicesResponse[0]);
    }

    public function testCreateOrder()
    {
        $orderResponse = app()->make('cashsmm')
            ->setProvider($this->getProvider())
            ->setOrder($this->getOrder())
            ->placeOrder();
        $this->assertIsArray($orderResponse);
        $this->assertArrayHasKey('reference', $orderResponse);
        $this->assertEquals('true' ,$orderResponse['is_success']);
        $this->assertArrayHasKey('order', $orderResponse);
        $this->assertEquals($this->getOrder()['id'], $orderResponse['order']['id']);
        $this->assertEquals($this->getOrder()['service'], $orderResponse['order']['service']);
        $this->assertEquals($this->getOrder()['link'], $orderResponse['order']['link']);
        $this->assertEquals($this->getOrder()['quantity'], $orderResponse['order']['quantity']);
    }

    public function testGetOrderStatus()
    {
        $servicesResponse = app()->make('cashsmm')
            ->setProvider($this->getProvider())
            ->getOrderStatus('726','31317');
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('status', $servicesResponse);
    }

    public function testGetBalance()
    {
        $servicesResponse = app()->make('cashsmm')
            ->setProvider($this->getProvider())
            ->getUserBalance();
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('balance', $servicesResponse);
    }        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('status', $servicesResponse);
    }

    public function testGetBalance()
    {
        $servicesResponse = app()->make('cashsmm')
            ->setProvider($this->getProvider())
            ->getUserBalance();
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('balance', $servicesResponse);
    }
    {
        $servicesResponse = app()->make('cashsmm')
            ->setProvider($this->getProvider())
            ->getUserBalance();
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('balance', $servicesResponse);
    }
=======
    public function testGetBalance()
    {
        $servicesResponse = app()->make('cashsmm')
            ->setProvider($this->getProvider())
            ->getUserBalance();
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('balance', $servicesResponse);
    }

}
