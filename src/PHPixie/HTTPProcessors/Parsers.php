<?php

namespace PHPixie\HTTPProcessors;

class Parsers
{
    protected $contentTypeMap = array(
        'application/json' => 'json'
    );
    
    protected $parsers = array();
    
    public function getForContentType($contentType)
    {
        $contentType = explode(';', $contentType, 2);
        $contentType = $contentType[0];
        
        if(!array_key_exists($contentType, $this->contentTypeMap)) {
            return null;
        }
        
        $name = $this->contentTypeMap[$contentType];
        return $this->parser($name);
    }
    
    public function json()
    {
        return $this->parser('json');
    }
    
    protected function parser($name)
    {
        if(!array_key_exists($name, $this->parsers)) {
            $method = 'build'.ucfirst($name);
            $this->parsers[$name] = $this->$method();
        }
        
        return $this->parsers[$name];
    }
    
    protected function buildJson()
    {
        return new Parsers\Parser\JSON();
    }
}
