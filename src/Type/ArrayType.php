<?php

namespace Precious\Type;

use Precious\SingletonScaffold;

class ArrayType extends PrimitiveType
{
    use SingletonScaffold;

    /**
     * @var mixed $value
     *
     * @throws WrongTypeException
     *
     * @returns array
     */
    public function cast($value)
    {
        if (!is_array($value)) {
            self::throwWrongTypeFor($value, 'array');
        }
        return $value;
    }
}
