<?php

namespace App\ExternalProviders\WDM;


class GetServices extends AbstractWDMOperation
{
    protected string $operationUrl = 'services';
    protected string $method = 'POST';


    public function returnExternalProviderResponse($jsonDecode): array
    {
        foreach ($jsonDecode as $service) {
            $response[] = [
                'service' => $service['service'],
                'name' => $service['name'],
                'rate' => $service['rate'],
                'min' => $service['min'],
                'max' => $service['max'],
                'category' => $service['category']
            ];
        }
        return $response;
    }
}
