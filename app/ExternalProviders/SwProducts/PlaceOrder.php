<?php

namespace App\ExternalProviders\SwProducts;

use App\ExternalProviders\ExternalProviderResponse;

class PlaceOrder extends AbstractSwProductsOperation
{
    protected string $operationUrl = 'games/requestorder';
    protected string $method = 'POST';

    public function setBody($order)
    {
        $this->body = [
            'service_id' => $order['service'],
            'gamer_id' => $order['link'],
            "game_id" => $order['category']
        ];
        return $this;
    }

    public function returnExternalProviderResponse($jsonDecode): array
    {
        $response = new ExternalProviderResponse();
        $response->setIsSuccess(true);
        $response->setPayload($jsonDecode);
        $response->setOrderId($jsonDecode['data']['id']);
        return $response->return();
    }
}
