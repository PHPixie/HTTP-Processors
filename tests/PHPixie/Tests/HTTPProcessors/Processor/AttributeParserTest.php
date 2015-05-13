<?php

namespace PHPixie\Tests\HTTPProcessors\Processor;

/**
 * @coversDefaultClass \PHPixie\HTTPProcessors\Processor\AttributeParser
 */
class AttributeParserTest extends \PHPixie\Test\Testcase
{
    protected $patternData = array(
        'fairy' => array(
            'regexp'  => 'test/5',
            'defaults' => array(
                
            ),
            'methods' => array('GET')
        ),
        'pixie' => array(
            'regexp'  => 'test/5',
            'defaults' => array(
                'pixie' => 'Trixie'
            ),
            'methods' => array()
        )
    );
    protected $attributeParser;
    protected $patterns;
    
    public function setUp()
    {
        $this->attributeParser = $this->getMockBuilder('\PHPixie\HTTPProcessors\Processor\AttributeParser')
            ->setMethods(array('buildPattern'))
            ->disableOriginalConstructor()
            ->getMock();
        
        $configData = $this->sliceData();
        
        $this->method($configData, 'keys', array_keys($this->patternData), array(), 0);
        $key = 0;
        foreach($this->patternData as $name => $data) {
            $patternConfig = $this->sliceData();
            $this->method($configData, 'slice', $patternConfig, array($name), $key+1);
            
            $pattern = $this->pattern($data);
            $this->method($this->attributeParser, 'buildPattern', $pattern, array($name, $patternConfig), $key);
            $key++;
        }
        
        $this->attributeParser->__construct($configData);
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
        $this->processTest('/test/5');
        $this->processTest('/test/fairy');
    }
    
    protected function processTest($path)
    {
        $serverRequest = $this->serverRequest();
        
        $this->method($serverRequest, 'getMethod', 'GET', array(), 0);
        
        $uri = $this->quickMock('\Psr\Http\Message\UriInterface');
        $this->method($uri, 'getPath', $path, array(), 0);
        $this->method($serverRequest, 'getUri', $uri, array(), 1);
        
        $this->attributeParser->process($serverRequest);
    }
    
    protected function pattern($data)
    {
        $pattern = $this->quickMock('\PHPixie\HTTPProcessors\Processor\AttributeParser\Pattern');
        
        foreach($data as $method => $value) {
            $this->method($pattern, $method, $value, array());
        }
        return $pattern;
    }
    
    protected function sliceData()
    {
        return $this->quickMock('\PHPixie\Slice\Data');
    }
    
    protected function serverRequest()
    {
        return $this->quickMock('\Psr\Http\Message\ServerRequestInterface');
    }

}