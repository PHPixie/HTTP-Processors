<?php

namespace PHPixie\Tests\HTTPProcessors\Parsers\Parser;

/**
 * @coversDefaultClass \PHPixie\HTTPProcessors\Parsers\Parser\JSON
 */
class JSONTest extends \PHPixie\Test\Testcase
{
    protected $json;
    
    public function setUp()
    {
        $this->json = new \PHPixie\HTTPProcessors\Parsers\Parser\JSON();
    }
    
    public function testParse()
    {
        $data = array('t' => 1);
        $encoded = json_encode($data);
        
        $this->assertSame($data, $this->json->parse($encoded));
        
        $json = $this->json;
        $this->assertException(function() use($json) {
            $json->parse('{t');
        }, '\PHPixie\HTTPProcessors\Exception');
    }
}