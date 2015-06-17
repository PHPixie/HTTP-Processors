<?php

namespace PHPixie\HTTPProcessors\Processor;

class UpdateContext implements \PHPixie\Processors\Processor
{
    protected $http;
    protected $settableContextContainer;
    
    public function __construct($http, $settableContextContainer)
    {
        $this->http = $http;
        $this->settableContextContainer = $settableContextContainer;
    }
    
    public function process($serverRequest)
    {
        $context = $this->http->serverRequestContext($serverRequest);
        $this->settableContextContainer->setHttpContext($context);
        return $serverRequest;
    }
}