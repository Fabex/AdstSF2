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

/**
 * Class ManagerSeriesProviderCompilerPass
 * @package Fabex\Bundle\AppBundle\DependencyInjection\CompilerPass
 */
class ManagerSeriesProviderCompilerPass implements CompilerPassInterface
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
        $taggedServices = $container->findTaggedServiceIds('adst.manager.series');
        if (count($taggedServices) != 1) {
            throw new Exception('You must have one and only one pen adst.manager.series service');
        }

        $definition = $container->getDefinition(array_keys($taggedServices)[0]);
        $container->setDefinition('fabex_app.manager.serie', $definition);
    }
}
