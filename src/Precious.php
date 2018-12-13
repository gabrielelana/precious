<?php

namespace Precious;

use Precious\Type\PrimitiveType;
use Precious\Type\ClassType;
use Precious\Type\Type;

abstract class Precious
{
    /**
     * @var array
     */
    private $parameters = [];

    /**
     * @var array<array<Field>>
     */
    private static $fields = [];

    /**
     * Returns a new instance of a value object
     *
     * @throws MissingRequiredFieldException
     * @throws WrongTypeFieldException
     * @throws MissingRequiredFieldException
     * @returns self
     */
    public function __construct(array $parameters = [])
    {
        if (!array_key_exists(static::class, self::$fields)) {
            self::$fields[static::class] = $this->init();
        }
        /** @var Field $field */
        foreach (self::$fields[static::class] as $field) {
            $this->parameters[$field->name()] = $field->pickIn($parameters);
        }
    }

    /**
     * @var string $name
     * @var mixed $value
     * @throws MissingRequiredFieldException
     * @throws WrongTypeFieldException
     * @returns self
     */
    public function set(string $name, $value) : self
    {
        return new static(array_merge($this->parameters, [$name => $value]));
    }

    public function __get($name)
    {
        if (!array_key_exists($name, $this->parameters)) {
            throw new UnknownFieldException("Unknown field `$name`");
        }
        return $this->parameters[$name];
    }

    public function __set($name, $value)
    {
        if (!array_key_exists($name, $this->parameters)) {
            throw new UnknownFieldException("Unknown field `$name`");
        }
        throw new ReadOnlyFieldException("Cannot write field `$name`");
    }

    protected static function required(string $fieldName, Type $fieldType) : Field
    {
        return new RequiredField($fieldName, $fieldType);
    }

    protected static function optional(string $fieldName, Type $fieldType, $defaultValue = null) : Field
    {
        return new OptionalField($fieldName, $fieldType, $defaultValue);
    }

    protected static function integerType() : Type
    {
        return PrimitiveType::integerType();
    }

    protected static function floatType() : Type
    {
        return PrimitiveType::floatType();
    }

    protected static function booleanType() : Type
    {
        return PrimitiveType::booleanType();
    }

    protected static function arrayType() : Type
    {
        return PrimitiveType::arrayType();
    }

    protected static function stringType() : Type
    {
        return PrimitiveType::stringType();
    }

    protected static function nullType() : Type
    {
        return PrimitiveType::nullType();
    }

    protected static function mixedType() : Type
    {
        return PrimitiveType::mixedType();
    }

    protected static function instanceOf(string $class) : Type
    {
        return ClassType::instanceOf($class);
    }

    /**
     * @returns array<Field>
     */
    abstract protected function init() : array;
}
