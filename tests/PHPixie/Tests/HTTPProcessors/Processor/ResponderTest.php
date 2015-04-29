<?php

namespace PHPixie\Tests\HTTPProcessors\Processor;

/**
 * @coversDefaultClass \PHPixie\HTTPProcessors\Processor\Responder
 */
class ResponderTest extends \PHPixie\Test\Testcase
{
    protected $responses;
    protected $responder;
    
    public function setUp()
    {
        $this->responses = $this->quickMock('\PHPixie\HTTP\Responses');
        $this->responder = new \PHPixie\HTTPProcessors\Processor\Responder($this->responses);
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
    public function testProcessResponse()
    {
        $response = $this->getResponse();
        $this->assertSame($response, $this->responder->process($response));
    }
    
    /**
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcessResponseMessage()
    {
        $response = $this->quickMock('\Psr\Http\Message\ResponseInterface');
        $this->assertSame($response, $this->responder->process($response));
    }
    
    /**
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcessString()
    {
        $response = $this->getResponse();
        $this->method($this->responses, 'string', $response, array('test'), 0);
        $this->assertSame($response, $this->responder->process('test'));
    }
    
    /**
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcessArray()
    {
        $array = array('t' => 1);
        $response = $this->getResponse();
        $this->method($this->responses, 'json', $response, array($array), 0);
        $this->assertSame($response, $this->responder->process($array));
    }
    
    /**
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcessObject()
    {
        $object = (object) array('t' => 1);
        $response = $this->getResponse();
        $this->method($this->responses, 'json', $response, array($object), 0);
        $this->assertSame($response, $this->responder->process($object));
    }
    
    /**
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcessException()
    {
        $responder = $this->responder;
        $this->assertException(function() use($responder) {
            $responder->process(8);
        }, '\PHPixie\HTTPProcessors\Exception');
    }
    
    /**
     * @covers ::name
     * @covers ::<protected>
     */
    public function testName()
    {
        $this->assertSame('responder', $this->responder->name());
    }
    
    protected function getResponse()
    {
        return $this->quickMock('\PHPixie\HTTP\Responses\Response');
    }
}