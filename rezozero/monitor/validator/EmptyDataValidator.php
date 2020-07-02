<?php

namespace rezozero\monitor\validator;

use rezozero\monitor\exception\WebsiteDownException;

class EmptyDataValidator extends AbstractDataValidator
{
    /**
     * @return void
     * @throws WebsiteDownException
     */
    public function validate()
    {
        if ($this->data === '') {
            throw new WebsiteDownException('Website data is empty');
        }
    }
}
