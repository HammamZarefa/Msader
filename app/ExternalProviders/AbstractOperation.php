<?php

namespace App\ExternalProviders;

use App\Exceptions\ExternalProviderRemoteException;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Models\ProviderLog as Log;

abstract class AbstractOperation
{
    protected string $requestDataType = "json";
    protected string $baseUrl;
    protected string $operationUrl;
    protected string $method;
    protected array $body;
    protected array $provider;
    protected string $orderId;
    protected $log;

    const STATUS_COMPLETE = 'completed';
    const STATUS_CANCELED = 'canceled';
    const STATUS_AWAITING = 'awaiting';
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_PROGRESS = 'progress';
    const STATUS_REFUNDED = 'refunded';


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
                "url" => $url = $this->getUrl(),
                "method" => $method = $this->getMethod(),
                "header" => $header = $this->getHeader(),
                "body" => $body = $this->getBody(),
                "order_id" => $this->getOrderId(),
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
            return ["is_success" => false , "error" => $e->getMessage()];
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
                return $this->returnExternalProviderResponse($jsonDecode ? $jsonDecode : $jsonResponse);
            }
        } catch (Exception $e) {
            throw new ExternalProviderRemoteException("External Provider Returned An Error: {$e->getMessage()}", $e->getCode(), $e);
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

    public static function getAvialableProviders()
    {
        return [
            "As7ab" => "as7ab",
            "CashSMM" => "cashsmm",
            "FasterSMM" => "fastersmm",
            "Lord" => "lord",
            "N1Panel" => "n1panel",
            "Nonvoip" => "nonvoip",
            "SmsActivate" => "smsactivate",
            "SpeedCard" => "speedcard",
            "SwProducts" => "swproducts",
            "WDM" => "wdm",
            "XpCard" => "xpcard",
            "SawaCard" => "sawacard",
        ];
    }
}
