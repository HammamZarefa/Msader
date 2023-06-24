<?php

namespace App\ExternalProviders\SmsActivate;

use App\ExternalProviders\ExternalProviderResponse;
use Illuminate\Support\Str;


class GetSMS extends AbstractSmsActivateOperation
{
    protected string $operationUrl;
    protected string $method = 'POST';


    public function setBody($order_id)
    {
        $this->operationUrl = "getStatus&id=" . $order_id;
        return $this;
    }


    public function returnExternalProviderResponse($jsonResponse): array
    {
        $jsonResponse = (string) $jsonResponse->getBody();
        $response = new ExternalProviderResponse();
        $response->setIsSuccess(true);
        $response->setPayload($jsonResponse);
        $response->setStatus($this->mapStatus($jsonResponse) ?? self::STATUS_CANCELED);
        $response->setCode(Str::contains($jsonResponse, 'STATUS_OK') ?
            trim($jsonResponse, "STATUS_OK:") : '');
        return $response->return();
    }


}
