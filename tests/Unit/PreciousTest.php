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
    public function testShallPass()
    {
        $a = new A();
    }
}
