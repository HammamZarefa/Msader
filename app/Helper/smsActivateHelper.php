<?php

namespace App\Helper;
include_once ("app/Services/smsactivateAPI.php");
class smsActivateHelper
{
    protected $smsActivate;

    public function __construct()
    {
    }
    public function getCountriesByService($service)
    {
        $sms = new \SMSActivate('72fc8d54db6955c737bA023792474e7f');
        $array=$sms->getTopCountriesByService($service);
        return $array;
    }
}
