<?php

namespace Precious\Type;

use Precious\SingletonScaffold;

class BooleanType extends PrimitiveType
{
    use SingletonScaffold;

    /**
     * @var mixed $value
     *
     * @throws WrongTypeException
     *
     * @returns bool
     */
    public function cast($value)
    {
        return (bool) $value;
    }
}
