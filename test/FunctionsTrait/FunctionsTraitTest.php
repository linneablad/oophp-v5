<?php

namespace liba19\FunctionsTrait;

use PHPUnit\Framework\TestCase;
use liba19\FunctionsTrait\FunctionsTrait;

/**
 * Test cases for trait FunctionsTrait.
 */
class FunctionsTraitTest extends TestCase
{
    use FunctionsTrait;

    /**
     * Test method slugify
     */
    public function testSlugify()
    {
        $mock = $this->getMockForTrait(FunctionsTrait::class);

        $res = $mock->slugify("Detta är en slug");
        $exp = "detta-ar-en-slug";
        $this->assertEquals($exp, $res);
    }


    /**
     * Test method esc() that uses htmlentities()
     */
    public function testEsc()
    {
        $mock = $this->getMockForTrait(FunctionsTrait::class);

        $res = $mock->esc("<b>boldtext</b>");
        $exp = "&lt;b&gt;boldtext&lt;/b&gt;";
        $this->assertEquals($exp, $res);
    }
}
