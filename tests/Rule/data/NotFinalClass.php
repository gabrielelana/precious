<?php

namespace PreciousClassMustBeFinalRule;

use Precious\Precious;

class NotFinalClass extends Precious
{
    protected function init() : array
    {
        return [
            self::required('a', self::integerType()),
        ];
    }
}
