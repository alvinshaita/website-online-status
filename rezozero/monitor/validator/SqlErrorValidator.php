<?php

namespace rezozero\monitor\validator;

use rezozero\monitor\exception\WebsiteDownException;

class SqlErrorValidator extends AbstractDataValidator
{
    /**
     * @return void
     * @throws WebsiteDownException
     */
    public function validate()
    {
        if (preg_match("/SQLSTATE\[[0-9]+\]/", $this->data) > 0) {
            throw new WebsiteDownException('An SQL error has been triggered');
        }
    }
}
