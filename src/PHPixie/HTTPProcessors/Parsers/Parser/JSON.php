<?php

namespace PHPixie\HTTPProcessors\Parsers\Parser;

class JSON implements \PHPixie\HTTPProcessors\Parsers\Parser
{
    public function parse($string)
    {
        $parsed = json_decode($string, true);
        
        $errorCode = json_last_error();
        if($errorCode !== JSON_ERROR_NONE) {
            throw new \PHPixie\HTTPProcessors\Exception("Error parsing JSON data");
        }
        
        return $parsed;
    }
}