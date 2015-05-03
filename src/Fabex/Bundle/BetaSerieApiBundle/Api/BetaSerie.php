<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 11/3/13
 * Time: 3:21 AM
 */

namespace Fabex\Bundle\BetaSerieApiBundle\Api;

use Fabex\Bundle\AppBundle\Provider\Serie\ManagerSerieInterface;
use Guzzle\Http\Client;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class BetaSerie
 * @package Fabex\Bundle\BetaSerieApiBundle\Api
 */
class BetaSerie implements ManagerSerieInterface
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
        die(dump($response));
//        $this->memberPlanning = $response->root->planning;
    }

    /**
     * @param $login
     * @param $password
     */
    public function memberAuthentication($login, $password)
    {
        $this->memberLogin = $login;
        $parameters = array('login' => $login, 'password' => md5($password));
        $response = $this->sendRequest('members/auth', $parameters);
        $this->memberToken = $response['member']['token'];
    }

    /**
     *
     */
    public function memberDestroy()
    {
        $this->sendRequest('members/destroy');
    }

    /**
     *
     */
    public function memberAllLastEpisode()
    {
        $parameters = array('view' => 'show');
        $response = $this->sendRequest('members/episodes/all', $parameters);
        die(dump($response));
//        $this->memberLastEpisode = $response->root->episodes;
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
     * @param $serie
     * @return mixed
     */
    public function serieSearch($serie)
    {
        $parameters = array('title' => $serie);
        $response = $this->sendRequest('shows/search', $parameters);
        die(dump($response));

//        return $response->root->shows;
    }

    /**
     * @param $serie
     * @return mixed
     */
    public function serieDisplay($serie)
    {
        $response = $this->sendRequest('shows/display/' . $serie);
        die(dump($response));

//        return $response->root;
    }

    /**
     * @param $serie
     */
    public function serieAdd($serie)
    {
        $this->sendRequest('shows/add/' . $serie);
    }

    /**
     * @param $serie
     * @param null $season
     * @param null $episode
     * @return mixed
     */
    public function serieEpisode($serie, $season = null, $episode = null)
    {
        $parameters = array('season' => $season, 'episode' => $episode);
        $response = $this->sendRequest('shows/episodes/' . $serie, $parameters);
        die(dump($response));

//        return $response->root->seasons;
    }

    /**
     * @param $serie
     * @param $season
     * @param $episode
     */
    public function episodeWatched($serie, $season, $episode)
    {
        $parameters = array('season' => $season, 'episode' => $episode);
        $this->sendRequest('members/watched/' . $serie, $parameters);
    }

    /**
     * @param $serie
     * @param $season
     * @param $episode
     */
    public function episodeDownloaded($serie, $season, $episode)
    {
        $parameters = array('season' => $season, 'episode' => $episode);
        $this->sendRequest('members/downloaded/' . $serie, $parameters);
    }

    /**
     * @param $login
     * @return \Buzz\Message\MessageInterface
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
        die(dump($response));

//        return $response->root->subtitles;
    }

    /**
     * @param $action
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
