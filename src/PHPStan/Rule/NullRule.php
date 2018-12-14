<?php

namespace Precious\PHPStan\Rule;

use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Rules\Rule;
use PHPStan\ShouldNotHappenException;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Precious\Precious;

class NullRule implements Rule
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
	 * @return array<string> errors
	 */
    public function processNode(Node $node, Scope $scope): array
	{
        return [];
    }
}
