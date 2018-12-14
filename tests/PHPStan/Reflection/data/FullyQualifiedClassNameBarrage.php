<?php

namespace Precious\Example;

use PHPStan\Type;
use PHPStan\Type\IntegerType;
use PHPStan\Type\ObjectType as AAA;
use Precious\Precious;

final class FullyQualifiedClassNameBarrage extends Precious
{
    protected function init() : array
    {
        return [
            self::required('a', self::instanceOf('Precious\Precious')),
            self::required('b', self::instanceOf(\PHPStan\Type\Type::class)),
            self::required('c', self::instanceOf(IntegerType::class)),
            self::required('d', self::instanceOf(Type\FloatType::class)),
            self::required('e', self::instanceOf(AAA::class)),
            self::required('f', self::instanceOf(Precious::class)),
            self::required('h', self::instanceOf(C::class)),
        ];
    }
}
