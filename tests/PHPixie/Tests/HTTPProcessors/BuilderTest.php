<?php

namespace PHPixie\Tests\HTTPProcessors;

/**
 * @coversDefaultClass \PHPixie\HTTPProcessors\Builder
 */
class BuilderTest extends \PHPixie\Test\Testcase
{
    protected $http;
    protected $builder;
    
    public function setUp()
    {
        $this->http = $this->quickMock('\PHPixie\HTTP');
        
        $this->builder = new \PHPixie\HTTPProcessors\Builder(
            $this->http
        );
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
    
    }
    
    /**
     * @covers ::buildRequestProcessor
     * @covers ::<protected>
     */
    public function testBuildRequestProcessor()
    {
        $processor = $this->builder->buildRequestProcessor();
        $this->assertInstance($processor, '\PHPixie\HTTPPRocessors\Processor\BuildRequest', array(
            'http' => $this->http
        ));
    }
    
    /**
     * @covers ::updateContextProcessor
     * @covers ::<protected>
     */
    public function testUpdateContextProcessor()
    {
        $contextContainer = $this->quickMock('\PHPixie\HTTP\Context\Container\Settable');
        
        $processor = $this->builder->updateContextProcessor($contextContainer);
        $this->assertInstance($processor, '\PHPixie\HTTPProcessors\Processor\UpdateContext', array(
            'http'                     => $this->http,
            'settableContextContainer' => $contextContainer
        ));
    }
    
    /**
     * @covers ::parseBodyProcessor
     * @covers ::<protected>
     */
    public function testParseBodyProcessor()
    {
        $processor = $this->builder->parseBodyProcessor();
        $this->assertInstance($processor, '\PHPixie\HTTPProcessors\Processor\ParseBody', array(
            'parsers' => $this->builder->parsers()
        ));
    }
    
    /**
     * @covers ::attributeRegistryDispatcher
     * @covers ::<protected>
     */
    public function testAttributeRegistryDispatcher()
    {
        $registry = $this->quickMock('\PHPixie\Processors\Registry');
        
        $processor = $this->builder->attributeRegistryDispatcher($registry, 'pixie');
        $this->assertInstance($processor, '\PHPixie\HTTPPRocessors\Processor\Dispatcher\Registry\Attribute', array(
            'registry'      => $registry,
            'attributeName' => 'pixie'
        ));
    }
    
    /**
     * @covers ::parsers
     * @covers ::<protected>
     */
    public function testParsers()
    {
        $parsers = $this->builder->parsers();
        $this->assertInstance($parsers, '\PHPixie\HTTPProcessors\Parsers');
        
        $this->assertSame($parsers, $this->builder->parsers());
    }
}