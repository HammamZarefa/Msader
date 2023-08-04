<?php

namespace App\ExternalProviders\As7ab;

use App\ExternalProviders\AbstractOperation;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AbstractAs7abOperation extends AbstractOperation
{
    public function getHeader(): array
    {
        return [
            "Content-Type" => "application/json",
            "Accept" => "application/json",
            "Authorization" => "Bearer " . $this->provider["api_key"]
        ];
    }

    public function getUrl()
    {
        return $this->getBaseUrl() . "/" . $this->getOperationUrl();
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
            'pending' => self::STATUS_PENDING,
            'processing' => self::STATUS_PROCESSING,
            'reject' => self::STATUS_REFUNDED,
            'completed' => self::STATUS_COMPLETE
        ];

        return $status[$remoteStatus] ?? $remoteStatus;
    }

}
