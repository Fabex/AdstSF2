<?php

namespace Fabex\Bundle\AppBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class FabexAppBundle
 * @package Fabex\Bundle\AppBundle
 */
class FabexAppBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new DependencyInjection\CompilerPass\ManagerSeriesProviderCompilerPass());
        $container->addCompilerPass(new DependencyInjection\CompilerPass\TorrentProviderCompilerPass());
        $container->addCompilerPass(new DependencyInjection\CompilerPass\SubtitleProviderCompilerPass());
    }
}
