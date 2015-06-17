<?php

namespace PHPixie\Tests\HTTPProcessors\Processor;

/**
 * @coversDefaultClass \PHPixie\HTTPProcessors\Processor\ParseBody
 */
class ParseBodyTest extends \PHPixie\Test\Testcase
{
    protected $parsers;
    protected $parseBody;
    
    public function setUp()
    {
        $this->parsers = $this->quickMock('\PHPixie\HTTPProcessors\Parsers');
        $this->parseBody = new \PHPixie\HTTPProcessors\Processor\ParseBody(
            $this->parsers
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
        $this->processTest(true);
        $this->processTest(false);
    }
    
    protected function processTest($isParsed = false)
    {
        $serverRequest = $this->quickMock('\Psr\Http\Message\ServerRequestInterface');
        
        $contentType = 'applciation/JSON';
        $this->method($serverRequest, 'getHeaderLine', $contentType, array('Content-Type'), 0);
        
        $parser = null;
        if($isParsed) {
            $parser = $this->quickMock('\PHPixie\HTTPProcessors\Parsers\Parser');
        }
        $lowerContentType = strtolower($contentType);
        $this->method($this->parsers, 'getForContentType', $parser, array($lowerContentType), 0);
        
        if($isParsed) {
            $body = $this->quickMock('\Psr\Http\Message\StreamInterface');
            $data = array('t'=>1);
            
            $this->method($serverRequest, 'getBody', $body, array(), 1);
            $this->method($body, '__toString', 'test', array(), 0);
            $this->method($parser, 'parse', $data, array('test'), 0);
            
            $expected = $this->quickMock('\Psr\Http\Message\ServerRequestInterface');
            $this->method($serverRequest, 'withParsedBody', $expected, array($data), 2);
            
        }else{
            $expected = $serverRequest;
        }
        
        $this->assertSame($expected, $this->parseBody->process($serverRequest));
    }
}