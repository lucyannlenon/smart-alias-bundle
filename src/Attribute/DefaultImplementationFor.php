<?php
namespace LENON\SmartAliasBundle\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class DefaultImplementationFor
{
    public function __construct(
        public string $interface,
        public ?string $alias = null
    ) {}
}
