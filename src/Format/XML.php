<?php

namespace App\Format;

use App\Format\Interfaces\FormatInterface;
use App\Format\Interfaces\FormatNameInterface;

class XML extends BaseFormat implements FormatInterface, FormatNameInterface
{
    public function convert(): string
    {
        return $this->toXML();
    }

    public function toXML(): string
    {
        $xml = '';

        foreach ($this->getData() as $key => $value) {
            $xml .= '<'.$key.'>'.$value.'</'.$key.'>';
        }

        return htmlspecialchars($xml);
    }

    public function getName(): string
    {
        return 'XML';
    }
}