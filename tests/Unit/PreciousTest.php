<?php

namespace Precious\Unit;

use PHPUnit\Framework\TestCase;
use Precious\Example\A;
use Precious\Example\B;
use Precious\Example\C;
use Precious\Example\D;
use SplStack;

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

    /**
     * @expectedException Precious\UnknownFieldException
     * @expectedExceptionMessage Unknown field `a4`
     */
    public function testCannotWriteUnknownFields()
    {
        $a = new A(['a1' => 1, 'a2' => 'aaa', 'a3' => 2]);
        $a->a4 = 6;
    }

    /**
     * @expectedException Precious\ReadOnlyFieldException
     * @expectedExceptionMessage Cannot write field `a1`
     */
    public function testCannotWriteReadOnlyFields()
    {
        $a = new A(['a1' => 1, 'a2' => 'aaa', 'a3' => 2]);
        $a->a1 = 2;
    }

    /**
     * @expectedException Precious\WrongTypeFieldException
     * @expectedExceptionMessage Wrong type for field `a1`. Value of type `NULL` cannot be casted to `integer`
     */
    public function testWrongTypeMessage()
    {
        $a = new A(['a1' => null, 'a2' => 'aaa', 'a3' => 2]);
    }

    /**
     * @expectedException Precious\WrongTypeFieldException
     * @dataProvider wrongTypes
     */
    public function testWrongType($parameters)
    {
        $b = new B($parameters);
    }

    public function wrongTypes()
    {
        return [
            // [['integer' => 1, 'float' => 1.1, 'boolean' => true, 'string' => 'foo', 'null' => null, 'mixed' => 'whatever', 'array' => [1, 2, 3]]],
            [['integer' => 'foo', 'float' => 1.1, 'boolean' => true, 'string' => 'foo', 'null' => null, 'mixed' => 'whatever', 'array' => [1, 2, 3]]],
            [['integer' => 1, 'float' => false, 'boolean' => true, 'string' => 'foo', 'null' => null, 'mixed' => 'whatever', 'array' => [1, 2, 3]]],
            // [['integer' => 1, 'float' => 1.1, 'boolean' => null, 'string' => 'foo', 'null' => null, 'mixed' => 'whatever', 'array' => [1, 2, 3]]],
            [['integer' => 1, 'float' => 1.1, 'boolean' => true, 'string' => [1, 2, 3], 'null' => null, 'mixed' => 'whatever', 'array' => [1, 2, 3]]],
            [['integer' => 1, 'float' => 1.1, 'boolean' => true, 'string' => 'foo', 'null' => 5, 'mixed' => 'whatever', 'array' => [1, 2, 3]]],
            [['integer' => 1, 'float' => 1.1, 'boolean' => true, 'string' => 'foo', 'null' => 'foo', 'mixed' => 'whatever', 'array' => [1, 2, 3]]],
            // [['integer' => 1, 'float' => 1.1, 'boolean' => true, 'string' => 'foo', 'null' => null, 'mixed' => 'whatever', 'array' => [1, 2, 3]]],
            [['integer' => 1, 'float' => 1.1, 'boolean' => true, 'string' => 'foo', 'null' => null, 'mixed' => 'whatever', 'array' => true]],
            [['integer' => 1, 'float' => 1.1, 'boolean' => true, 'string' => 'foo', 'null' => null, 'mixed' => 'whatever', 'array' => 1]],
            [['integer' => 1, 'float' => 1.1, 'boolean' => true, 'string' => 'foo', 'null' => null, 'mixed' => 'whatever', 'array' => 'foo']],
        ];
    }

    public function testCanContainInstancesOfClasses()
    {
        $c = new C(['a' => new SplStack()]);
        $this->assertInstanceOf(SplStack::class, $c->a);

        $c->a->push(1);
        $c->a->push(2);
        $c->a->push(3);
        $this->assertEquals([1, 2, 3], iterator_to_array($c->a));
    }

    public function testCanContainIntancesOfOtherPreciousObjects()
    {
        $d = new D(['c' => new C(['a' => new SplStack()])]);
        $this->assertInstanceOf(SplStack::class, $d->c->a);
    }
}
