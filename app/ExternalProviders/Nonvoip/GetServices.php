<?php

namespace App\ExternalProviders\Nonvoip;

use App\ExternalProviders\ExternalProviderResponse;

class GetServices extends AbstractNonvoipOperation
{
    protected string $operationUrl = 'get_service_list';
    protected string $method = 'POST';


    public function returnExternalProviderResponse($jsonDecode): array
    {
        foreach ($jsonDecode as $service) {
            $response[] = [
                'service' => $service['service_id'],
                'name' => $service['service_name'],
                'rate' => $service['price'],
                'rental_rate' => $service['rental_price']
            ];
        }
        return $response;
    }
}
