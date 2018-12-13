<?php

namespace Precious;

abstract class Precious
{
    const INTEGER= 'INTEGER';
    const FLOAT= 'FLOAT';
    const BOOLEAN= 'BOOLEAN';
    const ARRAY= 'ARRAY';
    const OBJECT= 'OBJECT';
    const NULL= 'NULL';
    const STRING= 'STRING';

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * @var array<Field>
     */
    private static $fields;

    /**
     * Returns a new instance of a value object
     *
     * @throws MissingRequiredFieldException
     *
     * @returns self
     */
    public function __construct(array $parameters = [])
    {
        if (!self::$fields) self::$fields = $this->init();
        /** @var Field $field */
        foreach (self::$fields as $field) {
            $this->parameters[$field->name()] = $field->pickIn($parameters);
        }
    }

    protected static function required(string $fieldName, string $fieldType) : Field
    {
        return new RequiredField($fieldName, $fieldType);
    }

    protected static function optional(string $fieldName, string $fieldType, $defaultValue = null) : Field
    {
        return new OptionalField($fieldName, $fieldType, $defaultValue);
    }

    /**
     * @returns array<Field>
     */
    abstract protected function init() : array;
}