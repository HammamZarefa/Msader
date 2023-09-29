<?php

namespace App\ExternalProviders\OnlySMM;

use App\ExternalProviders\AbstractOperation;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AbstractOnlySMMOperation extends AbstractOperation
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
        return $this->getBaseUrl() . "?key={$api_key}" .
            "&action={$this->getOperationUrl()}&" .
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
            "Pending" => self::STATUS_PENDING,
            "Cancel" => self::STATUS_REFUNDED,
            "Rejected" => self::STATUS_REFUNDED,
            "Completed" => self::STATUS_COMPLETE
        ];

        return $status[$remoteStatus] ?? $remoteStatus;
    }

}
