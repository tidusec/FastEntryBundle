<?php

namespace KimaiPlugin\FastEntryBundle;

use App\Plugin\PluginInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FastEntryBundle extends Bundle implements PluginInterface
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $loader = new \Symfony\Component\DependencyInjection\Loader\YamlFileLoader(
            $container,
            new \Symfony\Component\Config\FileLocator(__DIR__.'/Resources/config')
        );
        $loader->load('services.yaml');
    }
}