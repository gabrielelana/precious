<?php

namespace Precious\Type;

use Precious\SingletonScaffold;

class NullType extends PrimitiveType
{
    use SingletonScaffold;

    /**
     * @var mixed $value
     *
     * @throws WrongTypeException
     *
     * @returns null
     */
    public function cast($value)
    {
        if (!is_null($value)) {
            self::throwWrongTypeFor($value, 'null');
        }
        return null;
    }
}
