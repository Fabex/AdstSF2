<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 02/05/15
 * Time: 23:54
 */

namespace Fabex\Bundle\AppBundle\DependencyInjection\CompilerPass;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class TorrentProviderCompilerPass
 * @package Fabex\Bundle\AppBundle\DependencyInjection\CompilerPass
 */
class TorrentProviderCompilerPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $taggedServices = $container->findTaggedServiceIds('adst.provider.torrent');
        $definition = $container->getDefinition('fabex_app.provider.torrent');

        foreach($taggedServices as $id => $service) {
            $definition->addMethodCall('addProvider', array(new Reference($id)));
        }
    }
}
