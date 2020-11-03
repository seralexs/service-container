<?php

namespace App\Format;

use App\Format\Interfaces\FormatInterface;
use App\Format\Interfaces\FormatNameInterface;

class YAML extends BaseFormat implements FormatInterface, FormatNameInterface
{
    public function convert(): string
    {
        return $this->toYAML();
    }

    public function toYAML(): string
    {
        $yaml = '';

        foreach ($this->getData() as $key => $value) {
            $yaml .= $key.': '.$value.PHP_EOL;
        }

        return htmlspecialchars($yaml);
    }

    public function getName(): string
    {
        return 'YAML';
    }
}