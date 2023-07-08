<?php

namespace Tests\Feature\ESPTest;

use App\Facades\Nonvoip;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NonvoipTest extends TestCase
{
    use RefreshDatabase;

    public function getProvider()
    {
        return [
            "url" => 'https://non-voip.com/api/reseller',
            "NONVOIP_API_KEY" => env('NONVOIP_API_KEY'),
            "email" => env('NONVOIP_EMAIL')
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

    public function testGetSms()
    {
        $smsResponse = app()->make('nonvoip')
            ->setProvider($this->getProvider())
            ->getSms('732919');
        $this->assertIsArray($smsResponse);
        $this->assertArrayHasKey('service_id',$smsResponse['payload']);
    }
}
