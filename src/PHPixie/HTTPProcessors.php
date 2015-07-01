<?php

namespace PHPixie;

class HTTPProcessors
{
    protected $builder;
    
    public function __construct($http)
    {
        $this->builder = $this->buildBuilder($http);
    }
    
    public function updateContext($settableConextContainer)
    {
        return $this->builder->updateContextProcessor($settableConextContainer);
    }
    
    public function buildRequest()
    {
        return $this->builder->buildRequestProcessor();
    }
    
    public function parseBody()
    {
        return $this->builder->parseBodyProcessor();
    }
    
    public function attributeRegistryDispatcher($processorRegistry, $attributeName)
    {
        return $this->builder->attributeRegistryDispatcher(
            $processorRegistry,
            $attributeName
        );
    }
    
    public function builder()
    {
        return $this->builder;
    }
    
    protected function buildBuilder($http)
    {
        return new HTTPProcessors\Builder($http);
    }
}