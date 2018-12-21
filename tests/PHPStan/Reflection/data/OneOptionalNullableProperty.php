<?php

namespace Precious\Example;

use Precious\Precious;

final class OneOptionalNullableProperty extends Precious
{
    protected function init() : array
    {
        return [
            self::optional('a', self::integerType()),
        ];
    }
}
