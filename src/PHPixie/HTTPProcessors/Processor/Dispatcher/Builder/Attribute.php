<?php

namespace PHPixie\HTTPProcessors\Processor\Dispatcher\Builder;

abstract class Attribute extends \PHPixie\Processors\Processor\Dispatcher\Builder
{
    protected $attributeName = 'processor';
    
    protected function getProcessorNameFor($httpRequest)
    {
        return $httpRequest->attributes()->get($this->attributeName);
    }
}