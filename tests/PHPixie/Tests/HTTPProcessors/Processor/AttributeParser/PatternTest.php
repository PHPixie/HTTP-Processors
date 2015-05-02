<?php

namespace PHPixie\Tests\HTTPProcessors\Processor\AttributeParser;

/**
 * @coversDefaultClass \PHPixie\HTTPProcessors\Processor\AttributeParser\Pattern
 */
class PatternTest extends \PHPixie\Test\Testcase
{
    protected $slice;
    
    public function setUp()
    {
        $this->slice = new \PHPixie\Slice();
    }
    
    /**
     * @covers ::<public>
     * @covers ::<protected>
     */
    public function testConfig()
    {
        $sets = array(
            array(
                array(
                    'pattern'    => '(<pixie>(/<trixie>))',
                    'defaults'  => array(
                        'pixie' => 'fairy'
                    ),
                    'attributes' => array(
                        'pixie' => '[0-9]+'
                    ),
                    'methods' => array('GET')
                ),
                array(
                    'regexp'    => '(?:([0-9]+)(?:/([^/]+))?)?',
                    'parameterNames' => array('pixie', 'trixie'),
                )
            )
        );
        foreach($sets as $set) {
            $config = $this->slice->arrayData($set[0]);
            $pattern = $this->pattern('pixie', $config);
            
            $this->assertSame('pixie', $pattern->name());
            $methods = array_merge($set[0], $set[1]);
            unset($methods['attributes']);
            foreach($methods as $method => $value) {
                $this->assertSame($value, $pattern->$method());
            }
        }
    }
    
    protected function sliceData($data)
    {
        $slice = $this->quickMock('\PHPixie\Slice\Data');
        
        $this->method($slice, 'getRequired', $data['pattern'], array('pattern'), 0);
        
        $params = array(
            'defaults',
            'methods',
            'pattern'
        );
        foreach($params as $key => $name) {
            $this->method($slice, 'get', $data[$name], array($name, array()), $key+1);
        }
        
        return $slice;
    }
    
    public function pattern($name, $config)
    {
        return new \PHPixie\HTTPProcessors\Processor\AttributeParser\Pattern($name, $config);
    }
}