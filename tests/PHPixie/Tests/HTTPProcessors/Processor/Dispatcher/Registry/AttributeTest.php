<?php

namespace PHPixie\Tests\HTTPProcessors\Processor\Dispatcher\Registry;

/**
 * @coversDefaultClass \PHPixie\HTTPProcessors\Processor\Dispatcher\Registry\Attribute
 */
class AttributeTest extends \PHPixie\Tests\Processors\Processor\Dispatcher\RegistryTest
{
    protected $attributeName = 'fairy';
    
    /**
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcess()
    {
        $dispatcher = $this->dispatcher();
        
        $request = $this->getValue();
        
        $attributes = $this->quickMock('\PHPixie\Slice\Data');
        
        $this->method($attributes, 'get', 'pixie', array($this->attributeName), 0);
        
        $this->method($request, 'attributes', $attributes, array(), 0);
        
        $processor = $this->getProcessor();
        $this->method($this->registry, 'get', $processor, array('pixie'), 0);
        
        $this->method($processor, 'process', 'trixie', array($request), 0);
        
        $this->assertSame('trixie', $dispatcher->process($request));
    }
    
    protected function getValue()
    {
        return $this->quickMock('\PHPixie\HTTP\Request');
    }
    
    protected function dispatcher()
    {
        return new \PHPixie\HTTPProcessors\Processor\Dispatcher\Registry\Attribute(
            $this->registry,
            $this->attributeName
        );
    }
    
    protected function dispatcherMock($methods = array())
    {
        return $this->getMock(
            '\PHPixie\HTTPProcessors\Processor\Dispatcher\Registry\Attribute',
            $methods,
            array(
                $this->registry,
                $this->attributeName
            )
        );
    }
}