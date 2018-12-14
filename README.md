# Precious

Library to build value objects.

## Why

- A value object is **immutable**
- A value object should have a whell known set of attributes
- A value object is equal to another value object if they are
  **structurally equal** aka if they have the same attributes with the
  same values

In PHP there are no primitives to obtain this, what you can do is to
have objects with private properties, getters and a lot of boilerplate
code.

## Usage

``` php
<?php

use Precious\Precious;

final class Point extends Precious
{
    public static function from(int $x, int $y) : self
    {
        return new self(['x' => $x, 'y' => $y]);
    }

    protected function init() : array
    {
        return [
            self::required('x', self::integerType()),
            self::required('y', self::integerType()),
        ];
    }
}

$p1 = Point::from(1, 1);
$p2 = Point::from(1, 1);
$p3 = Point::from(2, 1);

assert($p1 == $p2);
assert($p1 != $p3);
assert($p1->x === $p2->x);
assert($p1->y === $p2->y);

$p4 = $p3->set('x', 1);
assert($p3 != $p4);
assert(spl_object_hash($p3) !== spl_object_hash($p4));
assert($p1 != $p3);
assert($p1 == $p4);
```

## Installation

``` shell
composer require gabrielelana/precious
```

## PHPStan

Another problem of solutions where you generate properties based on
some kind of definitions is that you will loose reference on the types
of those properties (by defining accessor methods by hand you will not
but you will have a lot of boilerplate code).

`PHPStan` support custom extensions that can be used to have the best
of both solutions: avoid the boilerplate and keep the type
information.

Install the suggested dependencies to use `Precious` at its full
potential.

``` shell
composer require --dev phpstan/phpstan
composer require --dev nikic/php-parser
```

Add the custom rules in your project `phpstan.neon` file

``` text
includes:
  - %currentWorkingDirectory%/vendor/gabrielelana/precious/rules.neon

parameters:
  level: 7
```

This what you should expect

``` php
<?php

use Precious\Precious;

final class Point extends Precious
{
    public static function from(int $x, int $y) : self
    {
        return new self(['x' => $x, 'y' => $y]);
    }

    protected function init() : array
    {
        return [
            self::required('x', self::integerType()),
            self::required('y', self::integerType()),
        ];
    }
}

function doSomething() : void {
    $p = Point::from(1, 1);
    echo $p->x . PHP_EOL;
    echo $p->y . PHP_EOL;
    // Will raise: Access to an undefined property Point::$z
    echo $p->z . PHP_EOL;
    // Will raise: Property Point::$x is not writable
    $p->x = 2;
    // Will raise: Parameter #1 $s of function doSomethingWith expects string, int given
    doSomethingWith($p->x);
}

function doSomethingWith(string $s) : string {
    return $s;
}
```
