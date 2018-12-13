<?php

namespace Precious;

use Precious\Type\Type;

class OptionalField extends RequiredField
{
    /**
     * @var mixed $defaultValue
     */
    private $defaultValue;

    /**
     * @var string $name
     * @var Type $type
     * @var mixed $defaultValue
     *
     * @returns self
     */
    public function __construct(string $name, Type $type, $defaultValue)
    {
        parent::__construct($name, $type);
        $this->defaultValue = $defaultValue;
    }

    /**
     * Returns the value of the field picked from an array of values
     *
     * @throws WrongTypeFieldException
     * @throws MissingRequiredFieldException
     *
     * @returns mixed
     */
    public function pickIn(array $parameters)
    {
        try {
            parent::pickIn($parameters);

        } catch (MissingRequiredFieldException $e) {
            return $this->cast($this->defaultValue);
        }
    }
}
