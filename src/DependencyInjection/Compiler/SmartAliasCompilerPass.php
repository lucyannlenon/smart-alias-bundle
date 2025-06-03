<?php
namespace LENON\SmartAliasBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use LENON\SmartAliasBundle\Generator\SmartAliasServiceFileGenerator;

class SmartAliasCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $env = $container->getParameter('kernel.environment');
        $generator = new SmartAliasServiceFileGenerator($container->getParameter('kernel.project_dir'));

        if ($env === 'dev') {
            $generator->generate();
        } elseif (!file_exists($container->getParameter('kernel.project_dir').'/config/smart_alias/services.php')) {
            $generator->generate();
        }
    }
}
