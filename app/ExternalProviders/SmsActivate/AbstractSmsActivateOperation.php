<?php

namespace App\ExternalProviders\SmsActivate;

use App\ExternalProviders\AbstractOperation;
use Illuminate\Support\Str;

class AbstractSmsActivateOperation extends AbstractOperation
{
    public function getHeader(): array
    {
        return [
            "Content-Type" => "application/json",
            "Accept" => "application/json",
        ];
    }

    public function getUrl()
    {
        $apikey = $this->provider["apikey"];
        return $this->getBaseUrl() . "?api_key={$apikey}" . "&action={$this->getOperationUrl()}";
    }

    public function getBody()
    {
        return $this->body ?? [];
    }

    public function getBaseUrl(): string
    {
        return $this->provider["url"];
    }

    public function mapStatus($response)
    {
        $status = [
            "STATUS_WAIT_CODE" => self::STATUS_PENDING,
            "STATUS_CANCEL" => self::STATUS_CANCELED,
            "WRONG_ACTIVATION_ID" => self::STATUS_CANCELED,
            "STATUS_OK" => self::STATUS_COMPLETE
        ];
        if (Str::contains($response, 'STATUS_OK'))
            $response = 'STATUS_OK';
        return $status[$response];
    }

}
