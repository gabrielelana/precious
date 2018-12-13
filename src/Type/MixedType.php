<?php

namespace Precious\Type;

use Precious\SingletonScaffold;

class MixedType extends PrimitiveType
{
    use SingletonScaffold;

    /**
     * @var mixed $value
     *
     * @throws WrongTypeException
     *
     * @returns mixed
     */
    public function cast($value)
    {
        return $value;
    }
}
