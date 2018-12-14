<?php

namespace Precious\Example;

use Precious\Precious;

final class ReadProperties extends Precious
{
    protected function init() : array
    {
        return [
            self::required('a', self::integerType()),
            self::required('b', self::integerType()),
            self::required('c', self::integerType()),
        ];
    }
}

function useless()
{
    $vo = new ReadProperties(['a' => 1, 'b' => 2, 'c' => 3]);
    echo $vo->a . PHP_EOL;
    echo $vo->b . PHP_EOL;
    echo $vo->c . PHP_EOL;
    // echo $vo->d . PHP_EOL;      // Access to an undefined property Precious\Example\ReadProperties::$d
    // $vo->a = 5;                 // Property Precious\Example\ReadProperties::$a is not writable
    // mustBeString($vo->c);       // // Parameter #1 $something of function Precious\Example\mustBeString expects string, int given
}

function mustBeString(string $something)
{
    echo $something . PHP_EOL;
}
