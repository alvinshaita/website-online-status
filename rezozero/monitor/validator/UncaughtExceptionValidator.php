<?php

namespace rezozero\monitor\validator;

use rezozero\monitor\exception\WebsiteDownException;

class UncaughtExceptionValidator extends AbstractDataValidator
{
    /**
     * @return void
     * @throws WebsiteDownException
     */
    public function validate()
    {
        if (preg_match("/Fatal error\: Uncaught exception/", $this->data) > 0) {
            throw new WebsiteDownException('An exception has been thrown and has not been catched');
        }
    }
}
