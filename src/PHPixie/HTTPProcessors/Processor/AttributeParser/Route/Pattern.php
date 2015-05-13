<?php

class Route
{
    protected $uriPattern;
    protected $hostPattern;
    
    public function hostPattern()
    {
        return $this->hostPattern;
    }
    
    public function uriPattern()
    {
        return $this->uriPattern;
    }
    
    public function uri()
    {
    
    }
}