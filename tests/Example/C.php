<?php

namespace Precious\Example;

use Precious\Precious;
use SplStack;

final class C extends Precious
{
    protected function init() : array
    {
        return [
            self::required('a', self::instanceOf(SplStack::class)),
        ];
    }
}
