<?php

namespace App\ExternalProviders\SwProducts;

use App\ExternalProviders\ExternalProviderResponse;

class GetOrderStatus extends AbstractSwProductsOperation
{
    protected string $operationUrl = 'games/orderDetails';
    protected string $method = 'GET';
    protected string $reference;

    public function setTrackId($trackId): AbstractSwProductsOperation
    {
        $this->trackId = $trackId;
        return $this;
    }

    public function setReference($reference): AbstractSwProductsOperation
    {
        $this->reference = $reference;
        return $this;
    }


    public function getOperationUrl(): string
    {
        return $this->operationUrl . '/' . $this->reference;
    }

    public function returnExternalProviderResponse($jsonDecode): array
    {
        $response = new ExternalProviderResponse();
        $response->setIsSuccess(true);
        $response->setPayload($jsonDecode);
        $response->setOrderId($this->getOrderId());
        $response->setStatus($jsonDecode['data']['order']['status']);
        return $response->return();
    }
}

