<?php

namespace PHPixie\HTTPProcessors\Processor;

class ParseBody implements \PHPixie\Processors\Processor
{
    protected $parsers;
    
    public function __construct($parsers)
    {
        $this->parsers = $parsers;
    }
    
    public function process($serverRequest)
    {
        $contentType = $serverRequest->getHeaderLine('Content-Type');
        $contentType = strtolower($contentType);
        
        $parser = $this->parsers->getForContentType($contentType);
        
        if($parser !== null) {
            $body = (string) $serverRequest->getBody();
            $parsed = $parser->parse($body);
            $serverRequest = $serverRequest->withParsedBody($parsed);
        }
        
        return $serverRequest;
    }
}