<?php


namespace App\ExternalProviders;


use App\Exceptions\ExternalProviderLocalException;
use Illuminate\Support\Facades\Validator;

abstract class AbstractValidator
{
    public array $rules = [];

    public function validate(array $inputs): array
    {
        $validator = Validator::make($inputs, $this->getRules());
        throw_if($validator->fails(), new ExternalProviderLocalException("Data Validation Exception, {$validator->errors()->toJson()}"));
        return $this->formatData($validator->validated());
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function formatData($data)
    {
        return $data;
    }
}
