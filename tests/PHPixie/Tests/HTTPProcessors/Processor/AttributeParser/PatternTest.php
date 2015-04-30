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
                    'pattern'    => '/<pixie>/<trixie>',
                    'defaults'  => array(
                        'pixie' => 'fairy'
                    ),
                    'attributes' => array(
                        'pixie' => '[0-9]+'
                    )
                ),
                array(
                    'regexp'    => '/(?P<pixie>[0-9]+)/(?P<trixie>[^/]+)',
                )
            )
        );
        foreach($sets as $set) {
            $config = $this->slice->arrayData($set[0]);
            $pattern = $this->pattern('pixie', $config);
            
            $this->assertSame('pixie', $pattern->name());
            $this->assertSame($set[0]['pattern'], $pattern->pattern());
            $this->assertSame($set[0]['defaults'], $pattern->defaults());
            
            $this->assertSame($set[1]['regexp'], $pattern->regexp());
        }
    }
    
    public function pattern($name, $config)
    {
        return new \PHPixie\HTTPProcessors\Processor\AttributeParser\Pattern($name, $config);
    }
}