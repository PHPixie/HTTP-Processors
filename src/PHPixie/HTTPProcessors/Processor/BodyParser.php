<?php

namespace PHPixie\HTTPProcessors\Processor;

class BodyParser implements \PHPixie\Processors\Processor
{
    protected $parsers;
    
    public function __construct($parsers)
    {
        $this->parsers = $parsers;
    }
    
    protected function parseServerRequest()
    {
        $contentType = $serverRequest->getHeaderLine('Content-Type');
        $parser = $parsers->getForType($contentType);
        if($parser !== null) {
            $body = (string) $serverRequest->getBody();
            $parsed = $parser->parse($body);
            $serverRequest = $serverRequest->withParsedBody($parsed);
        }
        
        return $serverRequest;
    }
    
    public function name()
    {
        return 'bodyParser';
    }
}