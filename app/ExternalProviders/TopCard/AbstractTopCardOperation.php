<?php

namespace App\ExternalProviders\TopCard;

use App\ExternalProviders\AbstractOperation;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AbstractTopCardOperation extends AbstractOperation
{
    public function getHeader(): array
    {
        return [
            "Content-Type" => "application/json",
            "Accept" => "application/json",
            "api-token" => $this->provider['api_key']
        ];
    }

    public function getUrl()
    {
        return $this->getBaseUrl() . "/" . $this->getOperationUrl() . "?" .
            Arr::query($this->getBody());
    }

    public function getBody()
    {
        return $this->body ?? [];
    }

    public function getBaseUrl(): string
    {
        return $this->provider["url"];
    }

    public function mapStatus($remoteStatus)
    {
        $status = [
            'wait' => self::STATUS_PENDING,
            'reject' => self::STATUS_REFUNDED,
            'accept' => self::STATUS_COMPLETE,
            'complete' => self::STATUS_COMPLETE
        ];

        return $status[$remoteStatus] ?? $remoteStatus;
    }

}
