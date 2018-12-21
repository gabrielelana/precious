<?php

namespace Precious\Example;

use Precious\Precious;

final class F extends Precious
{
    protected function init() : array
    {
        return [
            self::optional('a', self::integerType()),
            self::optional('b', self::floatType()),
            self::optional('c', self::stringType()),
            self::optional('d', self::nullType()),
            self::optional('e', self::booleanType()),
            self::optional('f', self::mixedType()),
            self::optional('g', self::arrayType()),
            self::optional('h', self::instanceOf('stdClass')),
        ];
    }
}
