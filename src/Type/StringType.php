<?php

namespace Precious\Type;

use Precious\SingletonScaffold;

class StringType extends PrimitiveType
{
    use SingletonScaffold;

    /**
     * @var mixed $value
     *
     * @throws WrongTypeException
     *
     * @returns string
     */
    public function cast($value)
    {
        if (is_string($value)) {
            return $value;
        }
        if (is_numeric($value)) {
            return (string) $value;
        }
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        if (method_exists($value, '__toString')) {
            return $value->__toString();
        }
        self::throwWrongTypeFor($value, 'string');
    }
}
