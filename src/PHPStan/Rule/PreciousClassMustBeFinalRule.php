<?php

namespace Precious\PHPStan\Rule;

use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Rules\Rule;
use PHPStan\ShouldNotHappenException;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Precious\Precious;

class PreciousClassMustBeFinalRule implements Rule
{
    /** @var Broker */
	private $broker;

	public function __construct(Broker $broker)
	{
		$this->broker = $broker;
	}

    /**
	 * @return string Node we are interested in
	 */
    public function getNodeType(): string
	{
		return Class_::class;
	}

    /**
	 * @param Node $node
	 * @param Scope $scope
	 * @throws ShouldNotHappenException
	 * @return array<string> errors
	 */
    public function processNode(Node $node, Scope $scope): array
	{
        assert($node instanceof Class_);
        $currentClassName = $node->namespacedName->toString();
        $currentClassReflection = $this->broker->getClass($currentClassName);
        $parentClassReflection = $currentClassReflection->getParentClass();
        if (!$parentClassReflection) {
            return [];
        }
        if ($parentClassReflection->getName() !== Precious::class) {
            return [];
        }
        if ($currentClassReflection->isFinal()) {
            return [];
        }
        return ['A subclass of Precious\Precious must be declared final'];
    }
}
