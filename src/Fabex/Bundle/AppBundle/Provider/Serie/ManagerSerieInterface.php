<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 02/05/15
 * Time: 14:48
 */

namespace Fabex\Bundle\AppBundle\Provider\Serie;

/**
 * Interface ManagerSerieInterface
 * @package Fabex\Bundle\AppBundle\Provider\Serie
 */
interface ManagerSerieInterface
{
    /**
     * @param $login
     * @param $password
     */
    public function authentication($login, $password);

    /**
     * @return array
     */
    public function getLastEpisodes();

    /**
     * @param string $serie
     * @param string $season
     * @param string $episode
     * @return mixed
     */
    public function toggleDownloadedEpisode($serie, $season, $episode);
}
