<?php

namespace PHPixie\HTTPProcessors\Processor\AttributeParser;

class Pattern
{
    protected $name;
    protected $pattern;
    protected $defaults;
    protected $parameterNames;
    
    public function __construct($name, $configData)
    {
        $this->name     = $name;
        $this->pattern  = $configData->getRequired('pattern');
        $this->defaults = $configData->get('defaults', array());
        $this->methods  = $configData->get('methods', array());
        
        $attributePatterns = $configData->get('attributes', array());
        
        $pattern = str_replace(
            array('(', ')'),
            array('(?:', ')?'),
            $this->pattern
        );
        
        $parameterNames = array();
        $this->regexp = preg_replace_callback(
            '#<(.*?)>#',
            function($matches) use($attributePatterns, &$parameterNames) {
                $parameterNames[]= $matches[1];
                if(array_key_exists($matches[1], $attributePatterns)) {
                    $regexp = $attributePatterns[$matches[1]];

                }else{
                    $regexp = '[^/]+';
                }
                return '('.$regexp.')';
            },
            $pattern
        );
        
        $this->parameterNames = $parameterNames;
    }
    
    public function name()
    {
        return $this->name;
    }
    
    public function pattern()
    {
        return $this->pattern;
    }
    
    public function regexp()
    {
        return $this->regexp;
    }
    
    public function defaults()
    {
        return $this->defaults;
    }
    
    public function methods()
    {
        return $this->methods;
    }
    
    public function parameterNames()
    {
        return $this->parameterNames;
    }
}