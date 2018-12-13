<?php

namespace Precious\Example;

use Precious\Precious;

final class A extends Precious
{
    protected function init() : array
    {
        return [
            self::required('a1', parent::INTEGER),
            self::required('a2', parent::STRING),
            self::optional('a3', parent::INTEGER, 0),
        ];
    }
}
