<?php

namespace PHPixie\HTTPProcessors\Processor\Respoder;

class Actions implements \PHPixie\HTTPProcessors\Processor\Responder
{
    protected function processRequest($configData, $request)
    {
        $action = $configData->get('action', 'default');
        $method = $action.'Action';
        
        return $this->$method($request, $configData);
    }
}