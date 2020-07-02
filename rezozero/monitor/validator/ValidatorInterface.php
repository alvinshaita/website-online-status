<?php

namespace rezozero\monitor\validator;

interface ValidatorInterface
{
    /**
     * @return void
     * @throws WebsiteDownException
     */
    public function validate();
}
