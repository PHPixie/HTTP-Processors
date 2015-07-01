<?php

namespace PHPixie\HTTPProcessors\Processor\Dispatcher\Registry;

class Attribute extends \PHPixie\Processors\Processor\Dispatcher\Registry
{
    protected $attributeName;
    
    public function __construct($processorRegistry, $attributeName)
    {
        $this->attributeName = $attributeName;
        parent::__construct($processorRegistry);
    }
    
    protected function getProcessorNameFor($httpRequest)
    {
        return $httpRequest->attributes()->get($this->attributeName);
    }
}