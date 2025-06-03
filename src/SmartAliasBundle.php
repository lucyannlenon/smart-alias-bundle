<?php
namespace LENON\SmartAliasBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use LENON\SmartAliasBundle\DependencyInjection\Compiler\SmartAliasCompilerPass;

class SmartAliasBundle extends Bundle
{
    public function build(ContainerBuilder $container):void
    {
        parent::build($container);
        $container->addCompilerPass(new SmartAliasCompilerPass());
    }
}
