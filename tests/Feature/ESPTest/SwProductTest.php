<?php

namespace ESPTest;

use App\Facades\SwProducts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SwProductTest extends TestCase
{

    use WithFaker;
    use RefreshDatabase;

    private $order = [
        'product' => 23,
        'service' => 33,
        'player_id' => 0000,
        'player_name' => 'تجريبي',
        "track_id" => '65665'
    ];
    private $refernce = '94839';
    public function setUp(): void
    {
        parent::setUp();
        $this->package = [
            "track_id" => $this->faker->text
        ];
    }

    public function getProvider()
    {
        return [
            "url" => 'https://sw-games.net/api/',
            "apikey" => '8|exZOPQiEKXllapPESxXFWuzgy7X1ECqRlR5PQAIj'
        ];
    }

    public function testGetBalance()
    {
        $getBalanceResponse = SwProducts::setProvider($this->getProvider())
            ->getUserBalance();
        $this->assertUnifiedResponse($getBalanceResponse);
        $this->assertArrayHasKey('data', $getBalanceResponse['payload']);
        $log = Log::all();
        dd($log);
    }

    public function testGetServices()
    {
        $getServicesResponse = SwProducts::setProvider($this->getProvider())
            ->getServices();
        $this->assertUnifiedResponse($getServicesResponse);
        $this->assertArrayHasKey('games', $getServicesResponse['payload']);
    }

    public function testPlaceOrder()
    {
        $getServicesResponse = SwProducts::setProvider($this->getProvider())
            ->setOrder($this->order)
            ->placeOrder();
        $this->assertUnifiedResponse($getServicesResponse);
        $this->assertArrayHasKey('data', $getServicesResponse['payload']);
        dd($getServicesResponse);
    }

    public function testGetOrderStatus()
    {
        $getoOrderStatusResponse = app()->make('swproducts')->setProvider($this->getProvider())
            ->GetOrderStatus($this->order['track_id'],$this->refernce);
        $this->assertUnifiedResponse($getoOrderStatusResponse);
        $this->assertArrayHasKey('data', $getoOrderStatusResponse['payload']);
    }
}