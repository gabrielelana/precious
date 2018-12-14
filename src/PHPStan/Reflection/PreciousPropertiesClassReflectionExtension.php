<?php

namespace Precious\PHPStan\Reflection;

use PHPStan\Broker\Broker;
use PHPStan\Reflection\BrokerAwareClassReflectionExtension;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\PropertiesClassReflectionExtension;
use PHPStan\Reflection\PropertyReflection;
use Precious\Precious;

class PreciousPropertiesClassReflectionExtension implements PropertiesClassReflectionExtension, BrokerAwareClassReflectionExtension
{
    /** @var Broker */
    private $broker;

    /** @var array<array<Property>> */
    private $properties;

    /**
     * @param Broker $broker Class reflection broker
     * @return void
     */
    public function setBroker(Broker $broker) : void
    {
        $this->broker = $broker;
        $this->properties = [];
    }

    /**
     * @param ClassReflection $classReflection
     * @param string $propertyName
     * @return bool
     */
    public function hasProperty(ClassReflection $classReflection, string $propertyName): bool
    {
        if (!$classReflection->isSubclassOf(Precious::class)) {
            return false;
        }
        $filePath = $classReflection->getFileName();
        if (!$filePath) {
            return false;
        }
        if (!array_key_exists($classReflection->getName(), $this->properties)) {
            $properties = PropertiesDetector::inFile($filePath);
            foreach ($properties as $className => $classProperties) {
                if ($className === $classReflection->getName()) {
                    foreach ($classProperties as $classPropertyName => $classProperty) {
                        $classProperty->inClass($classReflection);
                        $this->properties[$className][$classPropertyName] = $classProperty;
                    }
                }
            }
        }
        if (!array_key_exists($classReflection->getName(), $this->properties)) {
            return false;
        }
        return array_key_exists($propertyName, $this->properties[$classReflection->getName()]);
    }

    /**
     * @param ClassReflection $classReflection
     * @param string $propertyName
     * @return PropertyReflection
     */
    public function getProperty(ClassReflection $classReflection, string $propertyName): PropertyReflection
    {
        return $this->properties[$classReflection->getName()][$propertyName];
    }
}
