<?php

namespace Precious\Type;

interface Type
{
    /**
     * Cast a value in another value of a specific type
     *
     * @var mixed $value
     *
     * @throws WrongTypeException
     *
     * @returns mixed
     */
    public function cast($value);

}
