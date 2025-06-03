<?php
namespace LENON\SmartAliasBundle\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class ImplementationFor
{
    public function __construct(
        public string $interface,
        public ?string $tag = null
    ) {}
}
