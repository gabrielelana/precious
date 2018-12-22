<?php

namespace Precious\Type;

use Exception;

class ClassType implements Type
{
    /**
     * @var string
     */
    private $class;

    public static function instanceOf(string $class) : self
    {
        if (!class_exists($class) && !interface_exists($class)) {
            throw new Exception("Unknown class {$class}");
        }
        return new self($class);
    }

    private function __construct(string $class)
    {
        $this->class = $class;
    }

    /**
     * @var mixed $value
     *
     * @throws WrongTypeException
     *
     * @returns object
     */
    public function cast($value)
    {
        if (!($value instanceof $this->class)) {
            $currentClass = get_class($value);
            throw new WrongTypeException(
                "Value is not an instance of `{$this->class}` but an instance of `{$currentClass}`"
            );
        }
        return $value;
    }
}
