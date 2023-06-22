<?php

namespace Coda\ExternalProvider;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Zkood\DeliveryPortal\Exceptions\ProviderRemoteException;

abstract class AbstractOperation
{
    protected $requestDataType = "json";
    protected $baseUrl;
    protected $operationUrl;
    protected $method;
    protected $body;
    protected $provider;
    protected $orderId;
    protected $log;


    public function setProvider($provider): AbstractOperation
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * @return array|mixed
     * @throws GuzzleException
     * @throws Exception
     */
    public function send(): array
    {
        try {
            $logArray = [
                "order_id" => $orderId = $this->getOrderId(),
                "url" => $url = $this->getUrl(),
                "method" => $method = $this->getMethod(),
                "header" => $header = $this->getHeader(),
                "body" => $body = $this->getBody(),
            ];
            $this->dpLogger($logArray);
            $client = new Client();
            $options = [
                'headers' => $header,
                $this->requestDataType => $body,
            ];
            $response = $client->request($method, $url, $options);
            return $this->handleResponse($response);
        } catch (Exception $e) {
            throw new ProviderRemoteException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->getBaseUrl() . $this->getOperationUrl();
    }

    public function getOrderId()
    {
        return $this->orderId ?? "";
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return strtoupper($this->method);
    }

    /**
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }

    public function getOperationUrl(): string
    {
        return $this->operationUrl;
    }

    public function handleResponse($jsonResponse): array
    {
        try {
            $statusCode = $jsonResponse->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 300) {
                $jsonDecode = json_decode($jsonResponse->getBody()->getContents(), 1);
                $this->dpLogger(['disclosure' => $jsonDecode]);
                return $this->returnDeliveryPortalResponse($jsonDecode);
            }
        } catch (Exception $e) {
            throw new ProviderRemoteException("Delivery Portal Returned An Error: {$e->getMessage()}", $e->getCode(), $e);
        }
    }

    public function dpLogger($logArray)
    {
        logger(json_encode($logArray));

        if ($this->log && array_key_exists("disclosure", $logArray))
            $this->log->update($logArray);
        else
            $this->log = Log::create($logArray);
    }
}
