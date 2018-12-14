<?php

namespace Precious\Example;

use Precious\Precious;

final class OneRequiredProperty extends Precious
{
    protected function init() : array
    {
        return [
            self::required('a', self::integerType()),
        ];
    }
}
