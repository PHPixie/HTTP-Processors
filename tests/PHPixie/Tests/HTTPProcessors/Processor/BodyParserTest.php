<?php

namespace PHPixie\Tests\HTTPProcessors\Processor;

/**
 * @coversDefaultClass \PHPixie\HTTPProcessors\Processor\BodyParser
 */
class BodyParserTest extends \PHPixie\Test\Testcase
{
    protected $http;
    protected $parsers;
    protected $bodyParser;
    
    public function setUp()
    {
        $this->http = $this->quickMock('\PHPixie\HTTP');
        $this->parsers = $this->quickMock('\PHPixie\HTTPProcessors\Parsers');
        $this->bodyParser = new \PHPixie\HTTPProcessors\Processor\BodyParser(
            $this->http,
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
        $configData = $this->quickMock('\PHPixie\Slice\Data');
        $request = $this->quickMock('\PHPixie\HTTP\Request');
        
        $serverRequest = $this->quickMock('\Psr\Http\Message\ServerRequestInterface');
        $this->method($request, 'serverRequest',$serverRequest, array(), 0);
        
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
            
            $newServerRequest = $this->quickMock('\Psr\Http\Message\ServerRequestInterface');
            $this->method($serverRequest, 'withParsedBody', $newServerRequest, array($data), 2);
            
            $expected = $this->quickMock('\PHPixie\HTTP\Request');
            $this->method($this->http, 'request', $expected, array($newServerRequest), 0);
            
        }else{
            $expected = $request;
        }
        
        $this->assertSame($expected, $this->bodyParser->process($configData, $request));
    }
    
    /**
     * @covers ::name
     * @covers ::<protected>
     */
    public function testName()
    {
        $this->assertSame('bodyParser', $this->bodyParser->name());
    }
    
    protected function getSliceData()
    {
        return $this->quickMock('\PHPixie\Slice\Data');
    }
}