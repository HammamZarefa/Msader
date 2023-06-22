<?php

namespace App\Helper\ProviderHelper\Provider\SmsActivate;

class GetBalance extends AbstractSmsActivateOperation
{
    protected $operationUrl = 'getBalanceAndCashBack';
    protected $method = 'Get';

}
