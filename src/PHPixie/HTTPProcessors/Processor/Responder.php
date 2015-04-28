<?php

namespace PHPixie\HTTPProcessors\Processor;

class Responder implements \PHPixie\Processors\Processor
{
    protected $responses;
    
    public function __construct($responses)
    {
        $this->responses = $responses;
    }
    
    public function process($configData, $request)
    {
        $response = $this->processRequest($configData, $request);
        return $this->normalizeResponse($configData, $response);
    }
    
    protected function normalizeResponse($configData, $response)
    {
        if($response instanceof \PHPixie\HTTP\Responses\Response) {
            return $response;
        }
        
        if(is_scalar($response)) {
            return $this->responses->string($response);
        }
        
        if(is_object($response) || is_array($response)) {
            return $this->responses->json($response);
        }
        
        $type = get_type($response);
        throw new \PHPixie\HTTPProcessors\Exception("Cannot convert type '$type' into a response");
    }
}