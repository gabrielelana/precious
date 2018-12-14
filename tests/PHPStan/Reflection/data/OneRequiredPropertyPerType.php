<?php

namespace Precious\Example;

use Precious\Precious;

final class OneRequiredPropertyPerType extends Precious
{
    protected function init() : array
    {
        return [
            self::required('a', self::integerType()),
            self::required('b', self::floatType()),
            self::required('c', self::stringType()),
            self::required('d', self::booleanType()),
            self::required('e', self::arrayType()),
            self::required('f', self::nullType()),
            self::required('g', self::mixedType()),
            self::required('h', self::instanceOf('Precious\Precious')),
        ];
    }
}
