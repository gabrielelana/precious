<?php

namespace Precious\Rule;

use Precious\PHPStan\Rule\PreciousClassMustBeFinalRule;
use PHPStan\Testing\RuleTestCase;
use PHPStan\Rules\Rule;

class PreciousClassMustBeFinalRuleTest extends RuleTestCase
{
	protected function getRule(): Rule
	{
        $broker = $this->createBroker();
		return new PreciousClassMustBeFinalRule($broker);
	}

    public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/NotFinalClass.php'], [
			[
                'A subclass of Precious\Precious must be declared final',
				7,
			],
		]);
	}
}
