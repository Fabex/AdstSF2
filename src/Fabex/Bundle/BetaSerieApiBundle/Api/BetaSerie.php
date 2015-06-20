<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 11/3/13
 * Time: 3:21 AM
 */

namespace Fabex\Bundle\BetaSerieApiBundle\Api;

use Guzzle\Http\Client;

/**
 * Class BetaSerie
 * @package Fabex\Bundle\BetaSerieApiBundle\Api
 */
class BetaSerie
{
    const VERSION = '2.4';

    const KEY = 'a1020b4ecdb5';

    const API = 'http://api.betaseries.com/';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var
     */

    protected $memberLogin;
    /**
     * @var
     */
    protected $memberToken;
    /**
     * @var
     */
    protected $memberPlanning;
    /**
     * @var array
     */
    protected $memberLastEpisode = array();

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->memberDestroy();
    }

    /**
     * @return mixed
     */
    public function getPlanning()
    {
        return $this->memberPlanning;
    }

    /**
     * @return array
     */
    public function getLastEpisode()
    {
        return $this->memberLastEpisode;
    }

    /**
     *
     */
    public function memberPlanning()
    {
        $parameters = array('view' => 'unseen');
        $response = $this->sendRequest('planning/member/' . $this->memberLogin, $parameters);
        $this->memberPlanning = $response['planning'];
    }

    /**
     * @param string $login
     * @param string $password
     */
    public function memberAuthentication($login, $password)
    {
        $this->memberLogin = $login;
        $parameters = array('login' => $login, 'password' => md5($password));
        $response = $this->sendRequest('members/auth', $parameters);
        $this->memberToken = $response['member']['token'];
    }

    public function memberDestroy()
    {
        $this->sendRequest('members/destroy');
    }

    public function memberAllLastEpisode()
    {
        $parameters = array('view' => 'show');
        $response = $this->sendRequest('members/episodes/all', $parameters);

        foreach ($response['episodes'] as $episode) {
            $this->memberLastEpisode[] = $episode;
        }

        return $this->memberLastEpisode;
    }

    /**
     * @return array
     */
    public function memberLastEpisode()
    {
        $parameters = array('view' => 'next');
        $response = $this->sendRequest('members/episodes/all', $parameters);

        foreach ($response['episodes'] as $episode) {
            $this->memberLastEpisode[] = $episode;
        }

        return $this->memberLastEpisode;
    }

    /**
     * @param string $serie
     * @return mixed
     */
    public function serieSearch($serie)
    {
        $parameters = array('title' => $serie);
        $response = $this->sendRequest('shows/search', $parameters);

        return $response['shows'];
    }

    /**
     * @param string $serie
     * @return mixed
     */
    public function serieDisplay($serie)
    {
        $response = $this->sendRequest('shows/display/' . $serie);

        return $response;
    }

    /**
     * @param string $serie
     */
    public function serieAdd($serie)
    {
        $this->sendRequest('shows/add/' . $serie);
    }

    /**
     * @param string $serie
     * @param string $season
     * @param string $episode
     * @return mixed
     */
    public function serieEpisode($serie, $season = null, $episode = null)
    {
        $parameters = array('season' => $season, 'episode' => $episode);
        $response = $this->sendRequest('shows/episodes/' . $serie, $parameters);

        return $response['seasons'];
    }

    /**
     * @param string $serie
     * @param string $season
     * @param string $episode
     */
    public function episodeWatched($serie, $season, $episode)
    {
        $parameters = array('season' => $season, 'episode' => $episode);
        $this->sendRequest('members/watched/' . $serie, $parameters);
    }

    /**
     * @param string $serie
     * @param string $season
     * @param string $episode
     */
    public function episodeDownloaded($serie, $season, $episode)
    {
        $parameters = array('season' => $season, 'episode' => $episode);
        $this->sendRequest('members/downloaded/' . $serie, $parameters);
    }

    /**
     * @param string $login
     * @return mixed
     */
    public function memberSeries($login)
    {
        $response = $this->sendRequest('members/infos/' . $login);

        return $response;
    }

    /**
     * @param $serie
     * @param $season
     * @param $episode
     * @return mixed
     */
    public function getSubtitle($serie, $season, $episode)
    {
        $parameters = array('season' => $season, 'episode' => $episode, 'language' => 'vf');
        $response = $this->sendRequest('subtitles/show/' . $serie, $parameters);

        return $response['subtitles'];
    }

    /**
     * @param string $action
     * @param array $parameters
     * @return mixed
     */
    private function sendRequest($action, array $parameters = array())
    {
        $parameters['key'] = self::KEY;
        $parameters['v'] = self::VERSION;
        if (!empty($this->memberToken)) {
            $parameters['token'] = $this->memberToken;
        }
        $url = self::API . $action . '.json?' . time() . '&' . http_build_query($parameters);
        $request = $this->client->get($url);
        $response = $request->send();

        return $response->json()['root'];
    }
}
