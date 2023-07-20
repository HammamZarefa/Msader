<?php

namespace App\ExternalProviders\N1Panel;


class GetServices extends AbstractN1PanelOperation
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
                'refill' => $service['refill'],
                'cancel' => $service['cancel'],
            ];
        }
        return $response;
    }
}
