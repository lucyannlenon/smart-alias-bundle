<?php
namespace LENON\SmartAliasBundle\Tests;

use LENON\SmartAliasBundle\Attribute\DefaultImplementationFor;

#[DefaultImplementationFor(FooInterface::class)]
class FooA implements FooInterface {}
