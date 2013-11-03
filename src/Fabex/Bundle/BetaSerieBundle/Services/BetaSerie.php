<?php
/**
 * Created by PhpStorm.
 * User: fabex
 * Date: 11/3/13
 * Time: 3:21 AM
 */

namespace Fabex\Bundle\BetaSerieBundle\Services;

use Buzz\Browser;

class BetaSerie
{
    const key = 'a1020b4ecdb5';
    const api = 'http://api.betaseries.com/';

    private $memberLogin;
    private $memberToken;
    private $memberPlanning;
    private $memberLastEpisode = array();

    public function __construct(Browser $buzz)
    {
        $this->buzz = $buzz;
    }

    public function __destruct()
    {
        $this->memberDestroy();
    }

    public function getPlanning()
    {
        return $this->memberPlanning;
    }

    public function getLastEpisode()
    {
        return $this->memberLastEpisode;
    }

    public function memberPlanning()
    {
        $parameters = array('view' => 'unseen');
        $response = $this->sendRequest('planning/member/' . $this->memberLogin, $parameters);
        $this->memberPlanning = $response->root->planning;
    }

    public function memberAuthentication($login, $password)
    {
        $this->memberLogin = $login;
        $parameters = array('login' => $login, 'password' => md5($password));
        $response = $this->sendRequest('members/auth', $parameters);
        $this->memberToken = $response->root->member->token;
    }

    public function memberDestroy()
    {
        $this->sendRequest('members/destroy');
    }

    public function memberAllLastEpisode()
    {
        $parameters = array('view' => 'show');
        $response = $this->sendRequest('members/episodes/all', $parameters);
        $this->memberLastEpisode = $response->root->episodes;
    }

    public function memberLastEpisode()
    {
        $parameters = array('view' => 'next');
        $response = $this->sendRequest('members/episodes/all', $parameters);

        foreach ($response->root->episodes as $episode) {
            $this->memberLastEpisode[] = $episode;
        }
        return $this->memberLastEpisode;
    }

    public function serieSearch($serie)
    {
        $parameters = array('title' => $serie);
        $response = $this->sendRequest('shows/search', $parameters);
        return $response->root->shows;
    }

    public function serieDisplay($serie)
    {
        $response = $this->sendRequest('shows/display/' . $serie);
        return $response->root;
    }

    public function serieAdd($serie)
    {
        $this->sendRequest('shows/add/' . $serie);
    }

    public function serieEpisode($serie, $season = null, $episode = null)
    {
        $parameters = array('season' => $season, 'episode' => $episode);
        $response = $this->sendRequest('shows/episodes/' . $serie, $parameters);
        return $response->root->seasons;
    }

    public function episodeWatched($serie, $season, $episode)
    {
        $parameters = array('season' => $season, 'episode' => $episode);
        $this->sendRequest('members/watched/' . $serie, $parameters);
    }

    public function episodeDownloaded($serie, $season, $episode)
    {
        $parameters = array('season' => $season, 'episode' => $episode);
        $this->sendRequest('members/downloaded/' . $serie, $parameters);
    }

    public function memberSeries($login)
    {
        $response = $this->sendRequest('members/infos/' . $login);
        return $response;
    }

    public function getSubtitle($serie, $season, $episode)
    {
        $parameters = array('season' => $season, 'episode' => $episode, 'language'=>'vf');
        $response = $this->sendRequest('subtitles/show/' . $serie, $parameters);
        return $response->root->subtitles;
    }

    /**
     * @param $action
     * @param array $parameters
     * @return \Buzz\Message\MessageInterface
     */
    private function sendRequest($action, array $parameters = array())
    {

        $parameters['key'] = self::key;
        if (!empty($this->memberToken)) {
            $parameters['token'] = $this->memberToken;
        }
        $url = self::api . $action . '.json?' . time() . '&' . http_build_query($parameters);
        $response = $this->buzz->get($url);
        return json_decode($response->getContent());
    }

}