<?php

namespace App\ExternalProviders\SmsActivate;

use App\ExternalProviders\ExternalProviderResponse;
use Illuminate\Support\Str;


class GetSMS extends AbstractSmsActivateOperation
{
    protected string $operationUrl;
    protected string $method = 'POST';
    protected $order_id;

    /**
     * @return string
     */
    public function getOperationUrl(): string
    {
        return "getStatus&id=" . $this->order_id;
    }


    /**
     * @param mixed $order_id
     */
    public function setOrderId($order_id): void
    {
        $this->order_id = $order_id;
    }

    public function returnExternalProviderResponse($jsonResponse): array
    {
        $response = new ExternalProviderResponse();
        $response->setIsSuccess(true);
        $response->setPayload($jsonResponse);
        $response->setStatus($this->mapStatus($jsonResponse) ?? self::STATUS_CANCELED);
        $response->setCode(Str::contains($jsonResponse, 'STATUS_OK') ?
            trim($jsonResponse, "STATUS_OK:") : '');
        return $response->return();
    }


}
