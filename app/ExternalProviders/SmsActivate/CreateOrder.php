<?php

namespace App\ExternalProviders\SmsActivate;

class CreateOrder extends AbstractSmsActivateOperation
{
    protected string $method = 'GET';
    protected string $operationUrl;

    public function setBody($order)
    {
        $this->orderId = $order['id'] ?? '';
        $this->body = [
            "country" => json_decode($order['additional_param'])->country,
        ];
        if (strpos(json_decode($order['additional_param']->service), ',') !== false) {
            $this->body['multiService'] = json_decode($order['additional_param'])->service;
            $this->operationUrl = "getMultiServiceNumber";
        } else {
            $this->body['service'] = json_decode($order['additional_param'])->service;
            $this->operationUrl = "getNumberV2";
        }
        return $this;
    }
}
