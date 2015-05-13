<?php

namespace PHPixie\HTTPProcessors\Processor;

class AttributeParser implements \PHPixie\Processors\Processor
{
    protected $matcher;
    protected $patterns = array();
    
    public function __construct($configData)
    {
        foreach($configData->keys() as $name) {
            $patternData = $configData->slice($name);
            $pattern = $this->buildPattern($name, $patternData);
            $this->patterns[$name] = $pattern;
        }
    }
    
    public function process($serverRequest, $f = null)
    {
        $path = $serverRequest->getUri()->getPath();
        $attributes = $this->matcher->match($this->patterns, $path);
        
        if($attributes !== null) {
            foreach($attributes as $name => $value) {
                $serverRequest = $serverRequest->withAttribute($name, $value);
            }
        }
        
        return $serverRequest;
    }
    
    protected function buildPattern($name, $configData)
    {
        new AttributeParser\Pattern($name, $configData);
    }
    
    public function name()
    {
        return 1;
    }
}