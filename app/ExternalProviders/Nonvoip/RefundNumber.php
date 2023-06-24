<?php

namespace App\ExternalProviders\Nonvoip;

use App\ExternalProviders\ExternalProviderResponse;

class RefundNumber extends AbstractNonvoipOperation
{
    protected string $operationUrl = 'refund_number';
    protected string $method = 'POST';

    public function setBody($order_id)
    {
        $this->body = [
            "id" => $order_id
        ];
        return $this;
    }

    public function returnExternalProviderResponse($jsonDecode): array
    {
        $respons = new ExternalProviderResponse();
        $respons->setIsSuccess($jsonDecode['message'] == 'sucess' ? true : false);
        $respons->setPayload($jsonDecode);
        return $respons->return();
    }
}
