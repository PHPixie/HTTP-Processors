<?php

namespace PHPixie\Tests\HTTPProcessors\Processor\AttributeParser;

/**
 * @coversDefaultClass \PHPixie\HTTPProcessors\Processor\AttributeParser\Matcher
 */
class MatcherTest extends \PHPixie\Test\Testcase
{
    protected $matcher;
    protected $sets = array(
        array(
            'patterns' => array(
                array(
                    'regexp'  => 'test/([^/]+)',
                    'parameters' => array('id'),
                    'defaults'   => array()
                )
            ),
            'expect' => array(
                '/test/5' => array(
                    'id' => '5'
                ),
                '/fairy' => null
            )
        ),
        array(
            'patterns' => array(
                array(
                    'regexp'  => 'test/([^/]+)',
                    'parameters' => array('id'),
                    'defaults'   => array()
                ),
                array(
                    'regexp'     => '(?:([^/]+)(?:/([^/]+))?)?',
                    'parameters' => array('pixie', 'fairy'),
                    'defaults'   => array(
                        'pixie' => 'Trixie',
                        'fairy' => 'Blum'
                    )
                )
            ),
            'expect' => array(
                '/test/5' => array(
                    'id' => '5'
                ),
                '/test' => array(
                    'pixie' => 'test',
                    'fairy' => 'Blum'
                ),
                '/' => array(
                    'pixie' => 'Trixie',
                    'fairy' => 'Blum'
                )
            )
        )

    );
    
    public function setUp()
    {
        $this->matcher = new \PHPixie\HTTPProcessors\Processor\AttributeParser\Matcher();
    }
    
    /**
     * @covers ::match
     * @covers ::<protected>
     */
    public function testMatch()
    {
        foreach($this->sets as $set) {
            $patterns = array();
            foreach($set['patterns'] as $patternData) {
                $patterns[] = $this->pattern($patternData);
            }
            
            foreach($set['expect'] as $path => $result) {
                $parameters = $this->matcher->match($patterns, $path);
                $this->assertSame($result, $parameters);
            }
        }
    }
    
    protected function pattern($data)
    {
        $pattern = $this->quickMock('\PHPixie\HTTPProcessors\Processor\AttributeParser\Pattern');
        
        foreach($data as $method => $value) {
            $this->method($pattern, $method, $value, array());
        }
        return $pattern;
    }
    
}