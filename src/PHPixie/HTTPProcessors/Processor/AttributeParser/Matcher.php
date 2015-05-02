<?php

namespace PHPixie\HTTPProcessors\Processor\AttributeParser;

class Matcher
{
    public function match($patterns, $path)
    {
        if($path{0} === '/') {
            $path = substr($path, 1);
        }
        
        $parameters = null;
        $chunks = array_chunk($patterns, 10);
        foreach($chunks as $chunk) {
            $parameters = $this->matchPatterns($chunk, $path);
            if($parameters !== null) {
                break;
            }
        }
        return $parameters;
    }
    
    protected function matchPatterns($patterns, $path)
    {
        $target = str_pad('', count($patterns), '#').$path;
        
        $regexp   = '#^(?|';
        $first    = true;
        foreach($patterns as $key => $pattern) {
            
            if(!$first) {
                $regexp.='|';
            }else{
                $first = false;
            }
            
            $regexp.= '(\#{'.($key+1).'})\#*';
            $regexp.= $pattern->regexp();
        }
        
        $regexp.= ')$#';
        
        if(!preg_match($regexp, $target, $matches)) {
            return null;
        }
        
        $offset = strlen($matches[1]) - 1;
        $pattern = $patterns[$offset];
        
        $parameterNames = $pattern->parameters();
        $parameters = $pattern->defaults();
        
        $count = count($matches);
        for($i = 2; $i < $count; $i++) {
            if($matches[$i] !== '') {
                $name = $parameterNames[$i-2];
                $parameters[$name] = $matches[$i];
            }
        }
        
        return $parameters;    
    }
}