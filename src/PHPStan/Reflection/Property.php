<?php

namespace Precious\PHPStan\Reflection;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\Type\Type;

class Property implements PropertyReflection
{
    /** @var string */
    private $name;

    /** @var Type */
    private $type;

    /** @var ClassReflection */
    private $class;

    public function __construct(string $name, Type $type) {
        $this->name = $name;
        $this->type = $type;
    }

    public function inClass(ClassReflection $class) : void
    {
        $this->class = $class;
    }

    public function getType() : Type
    {
        return $this->type;
    }

	public function getDeclaringClass() : ClassReflection
    {
        return $this->class;
    }

	public function isStatic() : bool
    {
        return false;
    }

	public function isPrivate() : bool
    {
        return false;
    }

	public function isPublic() : bool
    {
        return true;
    }

    public function isReadable() : bool
    {
        return true;
    }

    public function isWritable() : bool
    {
        return false;
    }
}
