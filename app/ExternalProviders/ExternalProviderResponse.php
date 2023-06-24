<?php


namespace App\ExternalProviders;


class ExternalProviderResponse
{
    public $is_success;
    public $status;
    public $order_id; // Our generated number
    public $reference; // Shipping company generated number
    public $payload;
    private $custom_field;
    private $service;
    private $code;



    public function return(): array
    {
        $return["is_success"] = $this->getIsSuccess();
        $return["status"] = $this->getStatus();
        $return["order_id"] = $this->getOrderId();
        $return["reference"] = $this->getReference();
        $return["payload"] = $this->getPayload();
        $return["custom_field"] = $this->getCustomField();
        $return["service"] = $this->getService();
        $return["code"] = $this->getCode();
        return $return;
    }

    /**
     * @return mixed
     */
    public function getIsSuccess()
    {
        return $this->is_success;
    }

    /**
     * @param mixed $is_success
     * @return ExternalProviderResponse
     */
    public function setIsSuccess($is_success)
    {
        $this->is_success = $is_success;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return ExternalProviderResponse
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @param mixed $order_id
     * @return ExternalProviderResponse
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     * @return ExternalProviderResponse
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param mixed $payload
     * @return ExternalProviderResponse
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomField()
    {
        return $this->custom_field;
    }

    /**
     * @param mixed $reference
     * @return ExternalProviderResponse
     */
    public function setCustomField($custom_field)
    {
        $this->custom_field = $custom_field;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $reference
     * @return ExternalProviderResponse
     */
    public function setService($service)
    {
        $this->service = $service;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }
}
