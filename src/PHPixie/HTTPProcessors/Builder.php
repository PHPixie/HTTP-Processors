<?php

namespace PHPixie\HTTPProcessors;

class Builder
{
    protected $http;
    protected $parsers;
    
    public function __construct($http)
    {
        $this->http = $http;
    }
    
    public function updateContextProcessor($settableConextContainer)
    {
        return new Processor\UpdateContext(
            $this->http,
            $settableConextContainer
        );
    }
    
    public function buildRequestProcessor()
    {
        return new Processor\BuildRequest(
            $this->http
        );
    }
    
    public function parseBodyProcessor()
    {
        return new Processor\ParseBody(
            $this->parsers()
        );
    }
    
    public function attributeRegistryDispatcher($processorRegistry, $attributeName)
    {
        return new Processor\Dispatcher\Registry\Attribute(
            $processorRegistry,
            $attributeName
        );
    }
    
    public function parsers()
    {
        if($this->parsers === null) {
            $this->parsers = $this->buildParsers();
        }
        
        return $this->parsers;
    }
    
    protected function buildParsers()
    {
        return new Parsers();
    }
}