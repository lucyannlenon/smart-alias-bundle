<?php
namespace LENON\SmartAliasBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\Resource\FileResource;

class SmartAliasExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container):void
    {
        $file = $container->getParameter('kernel.project_dir') . '/config/smart_alias/services.php';

        if (file_exists($file)) {
            $container->addResource(new FileResource($file));

            $loader = new PhpFileLoader($container, new FileLocator(dirname($file)));
            $loader->load(basename($file));


        }
    }
}

