<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 03/05/15
 * Time: 01:23
 */

namespace Fabex\Bundle\AppBundle\Provider\Subtitle;

/**
 * Interface SubtitleProviderInterface
 * @package Fabex\Bundle\AppBundle\Provider\Subtitle
 */
interface SubtitleProviderInterface
{
    /**
     * @param string $serie
     * @param string $season
     * @param string $episode
     * @param string $fullNameSerie
     * @return array|mixed
     */
    public function getSubtitle($serie, $season, $episode, $fullNameSerie);

    /**
     * @return string
     */
    public function getName();
}
