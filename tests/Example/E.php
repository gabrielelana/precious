<?php

namespace Precious\Example;

use Precious\Precious;

final class E extends Precious
{
    protected function init() : array
    {
        return [
            self::required('a', self::integerType()),
            self::required('a', self::integerType()),
        ];
    }
}
