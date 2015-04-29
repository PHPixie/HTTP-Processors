<?php

namespace PHPixie\HTTPProcessors\Processor;

class Responder implements \PHPixie\Processors\Processor
{
    protected $responses;
    
    public function __construct($responses)
    {
        $this->responses = $responses;
    }
    
    public function process($value, $f = null)
    {
        if($value instanceof \PHPixie\HTTP\Responses\Response) {
            return $value;
        }
        
        if($value instanceof \Psr\Http\Message\ResponseInterface) {
            return $value;
        }
        
        if(is_string($value)) {
            return $this->responses->string($value);
        }
        
        if(is_object($value) || is_array($value)) {
            return $this->responses->json($value);
        }
        
        $type = gettype($value);
        throw new \PHPixie\HTTPProcessors\Exception("Cannot convert type '$type' into a response");
    }
    
    public function name()
    {
        return 'responder';
    }
}