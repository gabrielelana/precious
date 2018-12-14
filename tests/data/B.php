<?php

namespace Precious\Example;

use Precious\Precious;

final class B extends Precious
{
    protected function init() : array
    {
        return [
            self::required('integer', self::integerType()),
            self::required('float', self::floatType()),
            self::required('boolean', self::booleanType()),
            self::required('string', self::stringType()),
            self::required('null', self::nullType()),
            self::required('mixed', self::mixedType()),
            self::required('array', self::arrayType()),
        ];
    }
}
