<?php

namespace App\Format;

use App\Format\Interfaces\FormatFromStringInterface;
use App\Format\Interfaces\FormatInterface;
use App\Format\Interfaces\FormatNameInterface;

class JSON extends BaseFormat implements FormatInterface, FormatFromStringInterface, FormatNameInterface
{
    public function convertFromString($string)
    {
        return json_decode($string, true);
    }

    public function toJSON(): string
    {
        return json_encode($this->getData());
    }

    public function convert(): string
    {
        return $this->toJSON();
    }

    public function getName(): string
    {
        return 'JSON';
    }
}