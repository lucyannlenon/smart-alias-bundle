<?php
namespace LENON\SmartAliasBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\Resource\FileResource;

class SmartAliasExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $file = $container->getParameter('kernel.project_dir') . '/config/smart_alias/services.php';
        if (file_exists($file)) {
            $container->addResource(new FileResource($file)); // <- corrigido aqui
            $loader = require $file;
            $loader($container->getConfigurator());
        }
    }
}
