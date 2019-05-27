<?php

namespace Precious\Example;

use Precious\Precious;

final class G extends Precious
{
    protected function init() : array
    {
        return [
            self::optional('a', self::instanceOf(A::class)),
        ];
    }
}
