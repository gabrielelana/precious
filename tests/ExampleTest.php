<?php

namespace Precious;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testShallPass()
    {
        $this->assertNotNull(new Example());
    }
}
