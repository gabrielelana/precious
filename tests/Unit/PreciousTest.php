<?php

namespace Precious\Unit;

use PHPUnit\Framework\TestCase;
use Precious\Example\A;

class PreciousTest extends TestCase
{
    /**
     * @expectedException Precious\MissingRequiredFieldException
     * @expectedExceptionMessage Missing required field `a1`
     */
    public function testMissingRequiredField()
    {
        $a = new A();
    }

    /**
     * @expectedException Precious\MissingRequiredFieldException
     * @expectedExceptionMessage Missing required field `a2`
     */
    public function testWillComplainOnTheFirstMissingRequidfield()
    {
        $a = new A(['a1' => 1]);
    }

    public function testCanReadFieldsAsTheyWhereDeclaredPublic()
    {
        $a = new A(['a1' => 1, 'a2' => 'aaa', 'a3' => 2]);

        $this->assertEquals(1, $a->a1);
    }

    /**
     * @expectedException Precious\UnknownFieldException
     * @expectedExceptionMessage Unknown field `a4`
     */
    public function testCannotReadUnkownFields()
    {
        $a = new A(['a1' => 1, 'a2' => 'aaa', 'a3' => 2]);
        $a->a4;
    }
}
