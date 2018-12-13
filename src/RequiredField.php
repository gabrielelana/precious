<?php

namespace Precious;

use Precious\Type\Type;
use Precious\Type\WrongTypeException;

class RequiredField implements Field
{
    /**
     * @var string $name
     */
    private $name;

    /**
     * @var Type $type
     */
    private $type;

    public function __construct(string $name, Type $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * Returns the name of the field
     *
     * @returns string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Returns the value of the field picked from an array of values
     *
     * @throws WrongTypeFieldException
     * @throws MissingRequiredFieldException
     * @returns mixed
     */
    public function pickIn(array $parameters)
    {
        if (!array_key_exists($this->name, $parameters)) {
            throw new MissingRequiredFieldException(
                "Missing required field `{$this->name}`"
            );
        }
        return $this->cast($parameters[$this->name]);
    }

    /**
     * @var mixed $value
     * @throws WrongTypeFieldException
     * @returns mixed
     */
    protected function cast($value)
    {
        try {
            return $this->type->cast($value);

        } catch (WrongTypeException $e) {
            throw new WrongTypeFieldException(
                "Wrong type for field `{$this->name}`. {$e->getMessage()}"
            );
        }
    }
}
