<?php

namespace Precious\Example;

use Precious\Precious;

final class D extends Precious
{
    protected function init() : array
    {
        return [
            self::required('c', self::instanceOf(C::class)),
        ];
    }
}
