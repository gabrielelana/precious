<?php

namespace Precious\Example;

use Precious\Precious;

final class OneOptionalProperty extends Precious
{
    protected function init() : array
    {
        return [
            self::optional('a', self::integerType(), 0),
        ];
    }
}
