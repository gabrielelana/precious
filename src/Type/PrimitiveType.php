<?php

namespace Precious\Type;

use Precious\Singleton;

abstract class PrimitiveType implements Singleton, Type
{
    public static function integerType() : PrimitiveType
    {
        return IntegerType::instance();
    }

    public static function floatType() : PrimitiveType
    {
        return FloatType::instance();
    }

    public static function booleanType() : PrimitiveType
    {
        return BooleanType::instance();
    }

    public static function arrayType() : PrimitiveType
    {
        return ArrayType::instance();
    }

    public static function stringType() : PrimitiveType
    {
        return StringType::instance();
    }

    public static function nullType() : PrimitiveType
    {
        return NullType::instance();
    }

    public static function mixedType() : PrimitiveType
    {
        return MixedType::instance();
    }

    /**
     * @var mixed $value
     *
     * @throws WrongTypeException
     */
    protected static function throwWrongTypeFor($value, $expectedType) : void
    {
        $currentType = gettype($value);
        throw new WrongTypeException(
            "Value of type `{$currentType}` cannot be casted to `{$expectedType}`"
        );
    }
}
