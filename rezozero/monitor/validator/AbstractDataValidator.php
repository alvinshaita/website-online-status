<?php

namespace rezozero\monitor\validator;

abstract class AbstractDataValidator implements ValidatorInterface
{
    protected $data;

    public function __construct($data)
    {
        $this->data = trim($data);
    }
}
