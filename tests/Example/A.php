<?php

namespace Precious\Example;

use Precious\Precious;

final class A extends Precious
{
    protected function init() : array
    {
        return [
            self::required('a1', self::integerType()),
            self::required('a2', self::stringType()),
            self::optional('a3', self::integerType(), 0),
        ];
    }
}
