<?php

namespace PHPixie\Tests\HTTPProcessors;

/**
 * @coversDefaultClass \PHPixie\HTTPProcessors\Parsers
 */
class ParsersTest extends \PHPixie\Test\Testcase
{
    protected $parsers;
    
    public function setUp()
    {
        $this->parsers = new \PHPixie\HTTPProcessors\Parsers();
    }
    
    /**
     * @covers ::json
     * @covers ::<protected>
     */
    public function testJson()
    {
        $json = $this->parsers->json();
        $this->assertInstance($json, '\PHPixie\HTTPProcessors\Parsers\PArser\JSON');
        
        $this->assertSame($json, $this->parsers->json());
    }
    
    /**
     * @covers ::getForContentType
     * @covers ::<protected>
     */
    public function testGetForContentType()
    {
        $json = $this->parsers->getForContentType('application/json');
        $this->assertInstance($json, '\PHPixie\HTTPProcessors\Parsers\PArser\JSON');
        
        $this->assertSame(null, $this->parsers->getForContentType('test'));
    }
}