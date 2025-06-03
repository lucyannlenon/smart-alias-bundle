<?php

use PHPUnit\Framework\TestCase;
use LENON\SmartAliasBundle\Generator\SmartAliasServiceFileGenerator;
use LENON\SmartAliasBundle\Attribute\DefaultImplementationFor;

class SmartAliasServiceFileGeneratorTest extends TestCase
{
    public function testDuplicateDefaultImplementationThrowsException(): void
    {
        $dir = __DIR__ . '/Fixtures/Duplicates';
        $generator = new SmartAliasServiceFileGenerator($dir);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Duplicate DefaultImplementationFor for interface");

        $generator->generate();
    }
}
