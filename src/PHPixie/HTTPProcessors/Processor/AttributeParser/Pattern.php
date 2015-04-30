<?php

namespace PHPixie\HTTPProcessors\Processor\AttributeParser;

class Pattern
{
    protected $name;
    protected $pattern;
    protected $defaults;
    
    public function __construct($name, $configData)
    {
        $this->name     = $name;
        $this->pattern  = $configData->getRequired('pattern');
        $this->defaults = $configData->get('defaults', array());
        
        $attributePatterns = $configData->get('attributes', array());
        
        $this->regexp = preg_replace_callback(
            '#<(.*?)>#',
            function($matches) use($attributePatterns) {
                if(array_key_exists($matches[1], $attributePatterns)) {
                    $regexp = $attributePatterns[$matches[1]];

                }else{
                    $regexp = '[^/]+';
                }
                return '(?P'.$matches[0].$regexp.')';
            },
            $this->pattern
        );
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
}