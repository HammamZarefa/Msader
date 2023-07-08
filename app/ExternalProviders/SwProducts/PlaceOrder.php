<?php

namespace App\ExternalProviders\SwProducts;

use App\ExternalProviders\ExternalProviderResponse;

class PlaceOrder extends AbstractSwProductsOperation
{
    protected string $operationUrl = 'games/requestorder';
    protected string $method = 'POST';

    public function setBody($order)
    {
        $this->trackId = $order['track_id'];
        $this->body = [
            'game_id' => $order['product'],
            'service_id' => $order['service'],
            'gamer_id' => $order['player_id'],
            'username' => $order['player_name']
        ];
        return $this;
    }

    public function returnExternalProviderResponse($jsonDecode): array
    {
        $response = new ExternalProviderResponse();
        $response->setIsSuccess(true);
        $response->setPayload($jsonDecode);
        $response->setOrderId($this->getOrderId());
        return $response->return();
    }
}
