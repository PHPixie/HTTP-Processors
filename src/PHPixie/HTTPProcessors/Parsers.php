<?php

namespace PHPixie\HTTPProcessors;

class Parsers
{
    protected $map = array(
        'application/json' => 'json'
    );
    
    public function getForContentType($contentType)
    {
        if(!array_key_exists($contentType, $this->map)) {
            return null;
        }
        
        $name = $this->map[$contentType];
        return $this->get($name);
    }
}