<?php

namespace PHPixie\HTTPProcessors\Processor;

class BodyParser implements \PHPixie\Processors\Processor
{
    protected $http;
    protected $parsers;
    
    public function __construct($http, $parsers)
    {
        $this->http    = $http;
        $this->parsers = $parsers;
    }
    
    public function process($configData, $request)
    {
        $serverRequest = $request->serverRequest();
        
        $contentType = $serverRequest->getHeaderLine('Content-Type');
        $contentType = strtolower($contentType);
        
        $parser = $this->parsers->getForContentType($contentType);
        
        if($parser !== null) {
            $body = (string) $serverRequest->getBody();
            $parsed = $parser->parse($body);
            $serverRequest = $serverRequest->withParsedBody($parsed);
            $request = $this->http->request($serverRequest);
        }
        
        return $request;
    }
    
    public function name()
    {
        return 'bodyParser';
    }
}