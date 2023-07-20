<?php

namespace App\ExternalProviders\FasterSMM;


class GetServices extends AbstractFasterSMMOperation
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
                "type" => $service['type'],
                "category" => $service['category'],
            ];
        }
        return $response;
    }
}
