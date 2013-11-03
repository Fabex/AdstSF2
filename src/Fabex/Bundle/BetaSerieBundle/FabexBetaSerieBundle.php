<?php

namespace Fabex\Bundle\BetaSerieBundle;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FabexBetaSerieBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator($this->getPath().'/Resources/config'));
        $loader->load('config.yml');
    }
}
