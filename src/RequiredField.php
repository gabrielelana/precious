<?php

namespace Precious;

class RequiredField implements Field
{
    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $type
     */
    private $type;

    public function __construct(string $name, string $type)
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
     * @throws MissingRequiredFieldException
     *
     * @returns mixed
     */
    public function pickIn(array $parameters)
    {
        if (!array_key_exists($this->name, $parameters)) {
            throw new MissingRequiredFieldException(
                "Missing required field `{$this->name}`"
            );
        }
        return $parameters[$this->name];
    }
}
