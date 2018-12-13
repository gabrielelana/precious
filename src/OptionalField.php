<?php

namespace Precious;

class OptionalField extends RequiredField
{
    /**
     * @var mixed $defaultValue
     */
    private $defaultValue;

    /**
     * @var string $name
     * @var string $type
     * @var mixed $defaultValue
     *
     * @returns self
     */
    public function __construct(string $name, string $type, $defaultValue)
    {
        parent::__construct($name, $type);
        $this->defaultValue = $defaultValue;
    }

    /**
     * Returns the value of the field picked from an array of values
     *
     * @throws MissingRequiredFieldException
     *
     * @returns mixed
     */
    public function pickIn(array $parameters)
    {
        try {
            parent::pickIn($parameters);

        } catch (MissingRequiredFieldException $e) {
            return $this->defaultValue;
        }
    }
}
