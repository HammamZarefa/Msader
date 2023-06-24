<?php

namespace Tests\Feature\ESPTest;

use App\Facades\Nonvoip;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NonvoipTest extends TestCase
{

    public function getProvider()
    {
        return [
            "url" => 'https://non-voip.com/api/reseller',
            "api_key" => 'B2TXJqzXKpcErK',
            "email" => 'msaderstore@gmail.com'
        ];
    }

    public function testGetServices()
    {
        $servicesResponse = app()->make('nonvoip')
            ->setProvider($this->getProvider())
            ->getServices();
        $this->assertIsArray($servicesResponse);
        $this->assertArrayHasKey('service_id',$servicesResponse[0]);
    }
}
