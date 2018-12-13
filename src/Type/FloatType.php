<?php

namespace Precious\Type;

use Precious\SingletonScaffold;

class FloatType extends PrimitiveType
{
    use SingletonScaffold;

    /**
     * @var mixed $value
     *
     * @throws WrongTypeException
     *
     * @returns float
     */
    public function cast($value)
    {
        if (!is_numeric($value)) {
            self::throwWrongTypeFor($value, 'float');
        }
        return (float) $value;
    }
}
