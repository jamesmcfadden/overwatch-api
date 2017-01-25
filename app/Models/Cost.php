<?php

namespace App\Models;

use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

class Cost implements Arrayable, Jsonable, JsonSerializable
{
    /**
     * @var string
     */
    public $currency;

    /**
     * @var int
     */
    public $value;

    /**
     * @param \App\Currency $currency
     * @param int $value
     */
    public function __construct(Currency $currency, $value)
    {
        $this->currency = $currency->name;
        $this->value = (int) $value;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'currency' => $this->currency,
            'value' => $this->value,
        ];
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
