<?php

namespace PHPixie\HTTPProcessors\Processor\Actions;

abstract class Attribute extends \PHPixie\Processors\Processor\Actions
{
    protected $attributeName = 'action';
    
    protected function getActionNameFor($httpRequest)
    {
        return $httpRequest->attributes()->get('action');
    }
}