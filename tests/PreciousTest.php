<?php

namespace Precious;

use PHPUnit\Framework\TestCase;
use Precious\MissingRequiredFieldException;
use Precious\UnknownFieldException;
use Precious\ReadOnlyFieldException;
use Precious\WrongTypeFieldException;
use Precious\Example\A;
use Precious\Example\B;
use Precious\Example\C;
use Precious\Example\D;
use Precious\Example\E;
use Precious\Example\F;
use Precious\Example\G;
use SplStack;

class PreciousTest extends TestCase
{
    public function testMissingRequiredField()
    {
        $this->expectException(MissingRequiredFieldException::class);
        $this->expectExceptionMessage('Missing required field `a1`');

        $a = new A();
    }

    public function testWillComplainOnTheFirstMissingRequidfield()
    {
        $this->expectException(MissingRequiredFieldException::class);
        $this->expectExceptionMessage('Missing required field `a2`');

        $a = new A(['a1' => 1]);
    }

    public function testCanReadFieldsAsTheyWhereDeclaredPublic()
    {
        $a = new A(['a1' => 1, 'a2' => 'aaa', 'a3' => 2]);

        $this->assertEquals(1, $a->a1);
    }

    public function testCannotReadUnkownFields()
    {
        $this->expectException(UnknownFieldException::class);
        $this->expectExceptionMessage('Unknown field `a4`');

        $a = new A(['a1' => 1, 'a2' => 'aaa', 'a3' => 2]);
        $a->a4;
    }

    public function testCannotWriteUnknownFields()
    {
        $this->expectException(UnknownFieldException::class);
        $this->expectExceptionMessage('Unknown field `a4`');

        $a = new A(['a1' => 1, 'a2' => 'aaa', 'a3' => 2]);
        $a->a4 = 6;
    }

    public function testCannotWriteReadOnlyFields()
    {
        $this->expectException(ReadOnlyFieldException::class);
        $this->expectExceptionMessage('Cannot write field `a1`');

        $a = new A(['a1' => 1, 'a2' => 'aaa', 'a3' => 2]);
        $a->a1 = 2;
    }

    public function testWrongTypeMessage()
    {
        $this->expectException(WrongTypeFieldException::class);
        $this->expectExceptionMessage('Wrong type for field `a1`. Value of type `NULL` cannot be casted to `integer`');

        $a = new A(['a1' => null, 'a2' => 'aaa', 'a3' => 2]);
    }

    /**
     * @dataProvider wrongTypes
     */
    public function testWrongType($parameters)
    {
        $this->expectException(WrongTypeFieldException::class);

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

    public function testNonClassInClassField()
    {
        $this->expectException(WrongTypeFieldException::class);
        $this->expectExceptionMessage('Wrong type for field `c`. '.'Value is not an instance of `Precious\Example\C` but a `string`');
        $d = new D(['c' => 'buzz']);
    }

    public function testSetWillCreateAnotherObject()
    {
        $a1 = new A(['a1' => 1, 'a2' => 'aaa', 'a3' => 2]);
        $a2 = $a1->set('a1', 2);
        $this->assertNotSame($a1, $a2);
    }

    public function testSetWillTypeCheckAsWell()
    {
        $this->expectException(WrongTypeFieldException::class);

        $a1 = new A(['a1' => 1, 'a2' => 'aaa', 'a3' => 2]);
        $a2 = $a1->set('a1', 'aaa');
    }

    public function testValueObjectMustBeEqualIfTheyHaveEqualValues()
    {
        $a1 = new A(['a1' => 1, 'a2' => 'aaa', 'a3' => 2]);
        $a2 = new A(['a1' => 1, 'a2' => 'aaa', 'a3' => 2]);
        $this->assertEquals($a1, $a2);
        $this->assertNotSame($a1, $a2);
    }

    public function testCannotHaveMoreThanOneFieldWithTheSameName()
    {
        $this->expectException(NameClashFieldException::class);
        $this->expectExceptionMessage('Cannot redeclare field `a`');

        new E(['a' => 1]);
    }

    public function testHasField()
    {
        $a1 = new A(['a1' => 1, 'a2' => 'aaa', 'a3' => 2]);
        $this->assertTrue($a1->has('a1'));
        $this->assertTrue($a1->has('a2'));
        $this->assertTrue($a1->has('a3'));
        $this->assertFalse($a1->has('a4'));
    }

    public function testGetField()
    {
        $a1 = new A(['a1' => 1, 'a2' => 'aaa', 'a3' => 2]);
        $this->assertEquals(1, $a1->get('a1'));
        $this->assertEquals('aaa', $a1->get('a2'));
        $this->assertEquals(2, $a1->get('a3'));
    }

    public function optionalFieldOfEveryTypeCanBeNull()
    {
        $f = new F([]);
        $this->assertNull($f->a);
        $this->assertNull($f->b);
        $this->assertNull($f->c);
        $this->assertNull($f->d);
        $this->assertNull($f->e);
        $this->assertNull($f->f);
        $this->assertNull($f->g);
        $this->assertNull($f->h);

        $f = new F([
            'a' => null, 'b' => null, 'c' => null,
            'd' => null, 'e' => null, 'f' => null,
            'g' => null, 'h' => null
        ]);
        $this->assertNull($f->a);
        $this->assertNull($f->b);
        $this->assertNull($f->c);
        $this->assertNull($f->d);
        $this->assertNull($f->e);
        $this->assertNull($f->f);
        $this->assertNull($f->g);
        $this->assertNull($f->h);
    }

    public function testJsonSerialisation()
    {
        $a = new A(['a1' => 2, 'a2' => 'foo']);
        $this->assertSame(
            [
                'a1' => 2,
                'a2' => 'foo',
                'a3' => 0,
            ],
            (array)json_decode((string)json_encode($a), true)
        );

        $g = new G(['a' => $a]);
        $this->assertSame(
            [
                'a' => [
                    'a1' => 2,
                    'a2' => 'foo',
                    'a3' => 0,
                ],
            ],
            (array)json_decode((string)json_encode($g), true)
        );
    }
}
