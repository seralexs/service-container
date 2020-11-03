<?php


namespace App\Format;


abstract class BaseFormat
{
    private $data = [];

    public function __toString()
    {
        return $this->convert();
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public abstract function convert(): string;
}