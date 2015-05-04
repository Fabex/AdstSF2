<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 03/05/15
 * Time: 12:22
 */

namespace Fabex\Bundle\BetaSerieManagerBundle\Manager;

use Fabex\Bundle\AppBundle\Provider\Serie\ManagerSerieInterface;
use Fabex\Bundle\BetaSerieApiBundle\Api\BetaSerie;

/**
 * Class BetaSerieManager
 * @package Fabex\Bundle\BetaSerieManagerBundle\Manager
 */
class BetaSerieManager implements ManagerSerieInterface
{

    /**
     * @var BetaSerie
     */
    protected $api;

    /**
     * @param BetaSerie $api
     */
    public function __construct(BetaSerie $api)
    {
        $this->api = $api;
    }

    /**
     * @param string $login
     * @param string $password
     */
    public function authentication($login, $password)
    {
        $this->api->memberAuthentication($login, $password);
    }

    public function getLastEpisodes()
    {
        return $this->api->memberLastEpisode();
    }

    /**
     * @param string $serie
     * @param string $season
     * @param string $episode
     * @return mixed
     */
    public function toggleDownloadedEpisode($serie, $season, $episode)
    {
        $this->api->episodeDownloaded($serie, $season, $episode);
    }
}
