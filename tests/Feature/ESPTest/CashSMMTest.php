<?php

namespace Tests\Feature\ESPTest;

use App\Facades\CashSMM;
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
            "service" => 12,
            "link" => "12122",
            "quantity" => 1000,
        ];
        return $this->order;
    }

    public function testGetServices()
    {
        $servicesResponse = app()->make('cachsmm')
            ->setProvider($this->getProvider())
            ->getServices();
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('service', $servicesResponse[0]);
    }

    public function testCreateOrder()
    {
        $servicesResponse = app()->make('cachsmm')
            ->setProvider($this->getProvider())
            ->placeOrder();
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('service', $servicesResponse[0]);
    }

    public function testGetOrderStatus()
    {
        $servicesResponse = app()->make('cachsmm')
            ->setProvider($this->getProvider())
            ->getOrderStatus('726','31317');
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('status', $servicesResponse);
    }
}
