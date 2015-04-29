<?php

namespace PHPixie\HTTPProcessors\Processor\Respoder;

class REST implements \PHPixie\HTTPProcessors\Processor\Responder
{
    protected function processRequest($configData, $request)
    {
        $requestMethod = $request->method();
        $method = 'process'.ucfirst
    }
}