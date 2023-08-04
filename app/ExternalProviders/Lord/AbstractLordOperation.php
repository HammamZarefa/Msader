<?php

namespace App\ExternalProviders\Lord;

use App\ExternalProviders\AbstractOperation;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AbstractLordOperation extends AbstractOperation
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
        $api_key = $this->provider["api_key"];
        return $this->getBaseUrl() . "/" . $this->getOperationUrl() . "?api={$api_key}&" .
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
            0 => self::STATUS_PENDING,
            1 => self::STATUS_REFUNDED,
            2 => self::STATUS_REFUNDED,
            3 => self::STATUS_COMPLETE
        ];

        return $status[$remoteStatus] ?? $remoteStatus;
    }

}
