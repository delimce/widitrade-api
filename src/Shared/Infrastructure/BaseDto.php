<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

abstract class BaseDto
{

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function toJson(): string
    {
        return json_encode(get_object_vars($this));
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
