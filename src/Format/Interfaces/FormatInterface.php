<?php

namespace App\Format\Interfaces;

interface FormatInterface
{
    public function convert(): string;
    public function setData(array $data): void;
}
