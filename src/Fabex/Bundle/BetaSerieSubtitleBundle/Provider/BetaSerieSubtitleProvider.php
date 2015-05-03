<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 03/05/15
 * Time: 01:21
 */

namespace Fabex\Bundle\BetaSerieSubtitleBundle\Provider;

use Fabex\Bundle\AppBundle\Provider\Subtitle\SubtitleProviderInterface;
use Fabex\Bundle\BetaSerieApiBundle\Api\BetaSerie;

/**
 * Class BetaSerieSubtitleProvider
 * @package Fabex\Bundle\BetaSerieSubtitleBundle\Provider
 */
class BetaSerieSubtitleProvider implements SubtitleProviderInterface
{
    /**
     * @var BetaSerie
     */
    protected $client;


    /**
     * @param BetaSerie $api
     */
    public function __construct(BetaSerie $api)
    {
        $this->api = $api;
    }

    /**
     * @param string $serie
     * @param string $season
     * @param string $episode
     * @param string $fullNameSerie
     * @return array|mixed
     */
    public function getSubtitle($serie, $season, $episode, $fullNameSerie)
    {
        $return = array();
        $subtitles = $this->api->getSubtitle($serie, $season, $episode);

        foreach($subtitles as $srt) {
            if($srt['season'] == $season && $srt['episode'] == $episode) {
                $return[] = array('name' => $srt['file'], 'file' => $srt['url']);
            }
        }

        return $return;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Beta Series';
    }
}
