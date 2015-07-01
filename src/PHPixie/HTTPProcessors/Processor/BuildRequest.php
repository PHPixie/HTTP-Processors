<?php

namespace PHPixie\HTTPProcessors\Processor;

class BuildRequest implements \PHPixie\Processors\Processor
{
    protected $http;
    
    public function __construct($http)
    {
        $this->http = $http;
    }
    
    public function process($serverRequest)
    {
        return $this->http->request($serverRequest);
    }
}