<?php

namespace PHPixie\Tests\HTTPProcessors\Processor;

/**
 * @coversDefaultClass \PHPixie\HTTPProcessors\Processor\JSONRequest
 */
class JSONRequestTest extends \PHPixie\Test\Testcase
{
    protected $http;
    protected $jsonRequest;
    
    public function setUp()
    {
        $this->http = $this->quickMock('\PHPixie\HTTP');
        $this->jsonRequest = new \PHPixie\HTTPProcessors\Processor\JSONRequest($this->http);
    }

    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
        
    }
    
    protected function prepareServerRequest($serverRequest, $body, $at = 0)
    {
        $body = $this->quickMock('\Psr\Http\Message\StreamInterface');
        $this->method($serverRequest, 'getBody', $body, array(), $at);
        $this->method($body, '__toString', $body, array(), 0);
        $this->method($body, '__toString', 'data', array(), 0);
    }
    
    /**
     * @covers ::name
     * @covers ::<protected>
     */
    public function testName()
    {
        $this->assertSame('chain', $this->chain->name());
    }
    
    protected function getSliceData()
    {
        return $this->quickMock('\PHPixie\Slice\Data');
    }
}