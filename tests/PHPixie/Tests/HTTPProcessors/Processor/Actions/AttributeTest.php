<?php

namespace PHPixie\Tests\HTTPProcessors\Processor\Actions;

/**
 * @coversDefaultClass \PHPixie\HTTPProcessors\Processor\Actions\Attribute
 */
class AttributeTest extends \PHPixie\Tests\Processors\Processor\ActionsTest
{
    protected $attributeName = 'action';
    
    /**
     * @covers ::isProcessable
     * @covers ::process
     * @covers ::<protected>
     */
    public function testActionName()
    {
        $processorMock = $this->processorMock(array(
            'pixieAction'
        ));
        
        $request = $this->getValue();
        
        $attributes = $this->quickMock('\PHPixie\Slice\Data');
        $this->method($attributes, 'get', 'pixie', array($this->attributeName));
        
        $this->method($request, 'attributes', $attributes, array());
        
        $this->assertSame(true, $processorMock->isProcessable($request));
        
        $result = new \stdClass();
        $this->method($processorMock, 'pixieAction', $result, array($request));
        $this->assertSame($result, $processorMock->process($request));
    }
    
    protected function getValue()
    {
        return $this->quickMock('\PHPixie\HTTP\Request');
    }
    
    protected function processorMock($methods = array())
    {
        return $this->quickMock('\PHPixie\HTTPProcessors\Processor\Actions\Attribute', $methods);
    }
}