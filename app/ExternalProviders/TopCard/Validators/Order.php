<?php

namespace App\ExternalProviders\TopCard\Validators;

use App\ExternalProviders\AbstractValidator;

class Order extends AbstractValidator
{
    public array $rules = [
        "service" => "required",
        "link" => "required",
        "quantity" => "required",
        "runs" => "",
        "interval" => "",
        "id" => "required"
    ];

}
