<?php

namespace rezozero\monitor\parser;

interface ParserInterface
{
    public function parse($data, array &$storage);
}
