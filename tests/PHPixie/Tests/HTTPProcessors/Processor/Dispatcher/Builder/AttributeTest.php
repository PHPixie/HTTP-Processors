<?php

namespace PHPixie\Tests\HTTPProcessors\Processor\Dispatcher\Builder;

/**
 * @coversDefaultClass \PHPixie\HTTPProcessors\Processor\Dispatcher\Builder\Attribute
 */
class AttributeTest extends \PHPixie\Tests\Processors\Processor\Dispatcher\BuilderTest
{
    protected $attributeName = 'processor';
    
    /**
     * @covers ::<protected>
     */
    public function testGetProcessorNameFor()
    {
        $dispatcherMock = $this->dispatcherMock(array(
            'buildPixieProcessor'
        ));
        
        $processor = $this->getProcessor();
        $this->method($dispatcherMock, 'buildPixieProcessor', $processor, array(), 'once');
        
        $request = $this->getValue();
        
        $attributes = $this->quickMock('\PHPixie\Slice\Data');
        $this->method($attributes, 'get', 'pixie', array($this->attributeName));
        
        $this->method($request, 'attributes', $attributes, array());
        
        $this->assertSame(true, $dispatcherMock->isProcessable($request));
        
        $result = new \stdClass();
        $this->method($processor, 'process', $result, array($request));
        $this->assertSame($result, $dispatcherMock->process($request));
    }
    
    protected function getValue()
    {
        return $this->quickMock('\PHPixie\HTTP\Request');
    }
    
    protected function dispatcherMock($methods = array())
    {
        return $this->getMock(
            '\PHPixie\HTTPProcessors\Processor\Dispatcher\Builder\Attribute',
            $methods
        );
    }
}