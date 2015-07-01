<?php

namespace PHPixie\Tests\HTTPProcessors\Processor;

/**
 * @coversDefaultClass \PHPixie\HTTPProcessors\Processor\BuildRequest
 */
class BuildRequestTest extends \PHPixie\Test\Testcase
{
    protected $http;
    
    protected $buildRequest;
    
    public function setUp()
    {
        $this->http = $this->quickMock('\PHPixie\HTTP');
        
        $this->buildRequest = new \PHPixie\HTTPProcessors\Processor\BuildRequest(
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
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcess()
    {
        $serverRequest = $this->quickMock('\Psr\Http\Message\ServerRequestInterface');
        
        $request = $this->quickMock('\PHPixie\HTTP\Request');
        $this->method($this->http, 'request', $request, array($serverRequest), 0);
        
        $this->assertSame($request, $this->buildRequest->process($serverRequest));
    }
}