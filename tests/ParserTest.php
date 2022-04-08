<?php

declare(strict_types=1);

namespace PHPStyle\Tests;

use PHPStyle\PHPStyle;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class ParserTest extends TestCase
{
    public function testSampleParsing(): void
    {
        $parser = new PHPStyle();
        $parser->getConfig('../phpstyle.neon');
        Assert::assertTrue(true); // no exceptions right?
    }
}
