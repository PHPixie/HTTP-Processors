<?php

namespace PHPixie\HTTPProcessors\Processor\AttributeParser;

interface Route
{
    public function match($serverRequest);
    public function uri($httpContext, $parameters);
}