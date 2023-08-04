<?php

namespace App\ExternalProviders\XpCard;

use App\Exceptions\ExternalProviderRemoteException;
use App\ExternalProviders\AbstractOperation;
use App\ExternalProviders\ExternalProviderResponse;

class GetOrderStatus extends AbstractXpCardOperation
{
    protected string $operationUrl = 'order-details';
    protected string $method = 'POST';

    public function setBody($reference)
    {
        $this->body = [
            'order_id' => $reference
        ];

        return $this;
    }

    public function setOrderId($orderId): AbstractOperation
    {
        $this->orderId = $orderId;
        return $this;
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
