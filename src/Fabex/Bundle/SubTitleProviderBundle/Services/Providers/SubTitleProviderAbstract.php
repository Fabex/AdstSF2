<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 11/3/13
 * Time: 6:38 AM
 */
namespace Fabex\Bundle\SubTitleProviderBundle\Services\Providers;

abstract class SubTitleProviderAbstract implements SubTitleProviderInterface
{
    protected $subtiles = array();

    protected function addSubtitle($name, $link)
    {
        $this->subtiles[] = array('name'=>$name, 'link'=>$link);
    }
}