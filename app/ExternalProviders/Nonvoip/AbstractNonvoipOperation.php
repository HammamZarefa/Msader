<?php

namespace App\ExternalProviders\Nonvoip;

use App\ExternalProviders\AbstractOperation;

class AbstractNonvoipOperation extends AbstractOperation
{
    public function getHeader(): array
    {
        return [
            "Content-Type" => "application/json",
            "Accept" => "application/json",
            "api_key" => $this->provider['api_key'],
            "email" => $this->provider['email']
        ];
    }

    public function getUrl()
    {
        return $this->getBaseUrl() . '/' . $this->getOperationUrl();
    }

    public function getBody()
    {
        return $this->body ?? [];
    }

    public function getBaseUrl(): string
    {
        return $this->provider["url"];
    }

}
