<?php

namespace App\Helper\ProviderHelper\Provider\SmsActivate;

use Coda\ExternalProvider\AbstractOperation;

class AbstractSmsActivateOperation extends AbstractOperation
{
    public function getHeader(): array
    {
        return [
            "Content-Type: application/json",
            "Accept: application/json",
        ];
    }

    public function getUrl()
    {
        $apikey = $this->provider["apikey"];
        return $this->getBaseUrl() . $this->getOperationUrl() . "?apikey={$apikey}";
    }

    public function getBody()
    {
        return $this->body ?? [];
    }
}
