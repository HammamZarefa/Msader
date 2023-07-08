<?php

namespace App\ExternalProviders\Nonvoip;

use App\ExternalProviders\ExternalProviderResponse;

class GetSMS extends AbstractNonvoipOperation
{
    protected string $operationUrl = 'get_messages ';
    protected string $method = 'POST';


    public function setBody($orderId)
    {
        $this->body=[
            'order_id' => $orderId
        ];
        return $this;
    }
    public function returnExternalProviderResponse($jsonDecode): array
    {
        $response = new ExternalProviderResponse();
        $response->setIsSuccess(true);
        $response->setStatus(isset($jsonDecode['code']) ? self::STATUS_COMPLETE :
                ($jsonDecode['text'] == 'Refunded' ? self::STATUS_CANCELED : ''));
        $response->setPayload($jsonDecode);
        $response->setOrderId($this->getOrderId());
        $response->setService($jsonDecode['service_id']);
        $response->setCode($jsonDecode['code']);
        return $response->return();
    }
}
