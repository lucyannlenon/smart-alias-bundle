<?php
namespace LENON\SmartAliasBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SmartAliasExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $file = $container->getParameter('kernel.project_dir') . '/config/smart_alias/services.php';
        if (file_exists($file)) {
            $container->addResource($file);
            $loader = require $file;
            $loader($container->getConfigurator());
        }
    }
}
