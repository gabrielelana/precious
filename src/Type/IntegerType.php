<?php

namespace Precious\Type;

use Precious\SingletonScaffold;

class IntegerType extends PrimitiveType
{
    use SingletonScaffold;

    /**
     * @var mixed $value
     *
     * @throws WrongTypeException
     *
     * @returns int
     */
    public function cast($value)
    {
        if (!is_numeric($value)) {
            self::throwWrongTypeFor($value, 'integer');
        }
        return (int) $value;
    }
}
