<?php

namespace App;

class Cost
{
    public $currency;

    public $value;

    public function __construct(Currency $currency, $value)
    {
        $this->currency = $currency->name;
        $this->value = (int) $value;
    }

    public function toArray()
    {
        return [
            'currency' => $this->currency,
            'value' => $this->value,
        ];
    }
}
