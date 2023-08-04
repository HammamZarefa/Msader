<?php

namespace App\ExternalProviders\As7ab;

use App\Exceptions\ExternalProviderRemoteException;
use App\ExternalProviders\AbstractOperation;
use App\ExternalProviders\ExternalProviderResponse;

class GetOrderStatus extends AbstractAs7abOperation
{
    protected string $operationUrl = 'order';
    protected string $method = 'POST';

    public function setBody($reference)
    {
        return [];
    }

    public function setOrderId($orderId): AbstractOperation
    {
        $this->orderId = $orderId;
        return $this;
    }

    public function setReference($reference): AbstractAs7abOperation
    {
        $this->reference = $reference;
        return $this;
    }

    public function getOperationUrl(): string
    {
        return $this->operationUrl . '/' . $this->reference;
    }

    public function returnExternalProviderResponse($jsonResponse): array
    {
        $response = new ExternalProviderResponse();
        if (isset($jsonDecode['result']) && $jsonDecode['result'] != 'success') {
            $response->setIsSuccess(false);
            $response->setPayload($jsonDecode);
        } else {
            $response->setIsSuccess(true);
            $response->setPayload($jsonResponse);
            $response->setOrderId($this->getOrderId());
            $response->setStatus($this->mapStatus($jsonResponse['items']['status']));
        }
        return $response->return();
    }
}
