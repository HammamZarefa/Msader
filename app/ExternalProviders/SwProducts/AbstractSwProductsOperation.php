<?php

namespace App\ExternalProviders\SwProducts;

use App\ExternalProviders\AbstractOperation;

class AbstractSwProductsOperation extends AbstractOperation
{
    public function getHeader(): array
    {
        return [
            "Content-Type" => "application/json",
            "Accept" => "application/json",
            "Authorization" => "Bearer ".$this->provider["apikey"]
        ];
    }

    public function getUrl()
    {
        return $this->getBaseUrl().$this->getOperationUrl();
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
