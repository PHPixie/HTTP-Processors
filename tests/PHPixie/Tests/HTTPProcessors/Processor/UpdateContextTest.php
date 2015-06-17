<?php

namespace PHPixie\Tests\HTTPProcessors\Processor;

/**
 * @coversDefaultClass \PHPixie\HTTPProcessors\Processor\UpdateContext
 */
class UpdateContextTest extends \PHPixie\Test\Testcase
{
    protected $http;
    protected $settableContextContainer;
    
    protected $updateContext;
    
    public function setUp()
    {
        $this->http = $this->quickMock('\PHPixie\HTTP');
        $this->settableContextContainer = $this->quickMock('\PHPixie\HTTP\Context\Container\Settable');
        
        $this->updateContext = new \PHPixie\HTTPProcessors\Processor\UpdateContext(
            $this->http,
            $this->settableContextContainer
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
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcess()
    {
        $serverRequest = $this->quickMock('\Psr\Http\Message\ServerRequestInterface');
        $context = $this->quickMock('\PHPixie\HTTP\Context');
        
        $this->method($this->http, 'serverRequestContext', $context, array($serverRequest), 0);
        $this->method($this->settableContextContainer, 'setHttpContext', null, array($context), 0);
        
        $this->assertSame($serverRequest, $this->updateContext->process($serverRequest));
    }
}