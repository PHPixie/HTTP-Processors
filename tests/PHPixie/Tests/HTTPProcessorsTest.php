<?php

namespace PHPixie\Tests;

/**
 * @coversDefaultClass \PHPixie\HTTPProcessors
 */
class HTTPProcessorsTest extends \PHPixie\Test\Testcase
{
    protected $http;
    
    protected $httpProcessors;
    
    protected $builder;
    
    public function setUp()
    {
        $this->http = $this->quickMock('\PHPixie\HTTP');
        
        $this->httpProcessors = $this->getMockBuilder('\PHPixie\HTTPProcessors')
            ->setMethods(array('buildBuilder'))
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->builder = $this->quickMock('\PHPixie\HTTPProcessors\Builder');
        $this->method($this->httpProcessors, 'buildBuilder', $this->builder, array(
            $this->http
        ), 0);
        
        $this->httpProcessors->__construct(
            $this->http
        );
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstructor()
    {
        
    }
    
    /**
     * @covers ::buildRequest
     * @covers ::<protected>
     */
    public function testBuildRequest()
    {
        $processor = $this->quickMock('\PHPixie\HTTPPRocessors\Processor\BuildRequest');
        $this->method($this->builder, 'buildRequestProcessor', $processor, array(), 0);
        $this->assertSame($processor, $this->httpProcessors->buildRequest());
    }
    
    /**
     * @covers ::updateContext
     * @covers ::<protected>
     */
    public function testUpdateContext()
    {
        $contextContainer = $this->quickMock('\PHPixie\HTTP\Context\Container\Settable');
        
        $processor = $this->quickMock('\PHPixie\HTTPPRocessors\Processor\UpdateContext');
        $this->method($this->builder, 'updateContextProcessor', $processor, array($contextContainer), 0);
        $this->assertSame($processor, $this->httpProcessors->updateContext($contextContainer));
    }
    
    /**
     * @covers ::attributeRegistryDispatcher
     * @covers ::<protected>
     */
    public function testParameterRegistryDispatcher()
    {
        $registry = $this->quickMock('\PHPixie\Processors\Registry');
        
        $processor = $this->quickMock('\PHPixie\HTTPPRocessors\Processor\Dispatcher\Registry\Parameter');
        $this->method($this->builder, 'attributeRegistryDispatcher', $processor, array($registry, 'pixie'), 0);
        $this->assertSame($processor, $this->httpProcessors->attributeRegistryDispatcher($registry, 'pixie'));
    }
    
    /**
     * @covers ::parseBody
     * @covers ::<protected>
     */
    public function testParseBody()
    {
        $processor = $this->quickMock('\PHPixie\HTTPPRocessors\Processor\ParseBody');
        $this->method($this->builder, 'parseBodyProcessor', $processor, array(), 0);
        $this->assertSame($processor, $this->httpProcessors->parseBody());
    }
    
    /**
     * @covers ::buildBuilder
     * @covers ::<protected>
     */
    public function testBuildBuilder()
    {
        $this->httpProcessors = new \PHPixie\HTTPProcessors(
            $this->http
        );
        
        $builder = $this->httpProcessors->builder();
        $this->assertInstance($builder, '\PHPixie\HTTPProcessors\Builder', array(
            'http' => $this->http
        ));
    }
    
    /**
     * @covers ::builder
     * @covers ::<protected>
     */
    public function testBuilder()
    {
        $this->assertSame($this->builder, $this->httpProcessors->builder());
    }
}