<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 11/3/13
 * Time: 6:38 AM
 */
namespace Fabex\Bundle\SubTitleProviderBundle\Services\Providers;

interface SubTitleProviderInterface
{
    public function getSubTitle($serie, $fullNameSerie, $season, $episode);
}