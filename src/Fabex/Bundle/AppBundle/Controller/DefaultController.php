<?php

namespace Fabex\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package Fabex\Bundle\AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $episodes = $this->get('fabex_app.manager.serie')->getLastEpisodes();

        return $this->render('FabexAppBundle:Default:index.html.twig', array('episodes' => $episodes));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAllEpisodesAction()
    {
        $episodes = $this->get('fabex_app.manager.serie')->getAllLastEpisodes();

        return $this->render('FabexAppBundle:Default:index.html.twig', array('episodes' => $episodes));
    }

    /**
     * @param string $show
     * @param string $number
     * @param string $downloaded
     * @param string $season
     * @param string $episode
     * @param string $url
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getTorrentLinksAction($show, $number, $downloaded, $season, $episode, $url)
    {
        $bestTorrent = $this->get('fabex_app.provider.torrent')->getBestTorrent($show . ' ' . $number);

        return $this->render(
            'FabexAppBundle:Default:getTorrentLinks.html.twig',
            array(
                'show' => $show,
                'number' => $number,
                'downloaded' => $downloaded,
                'bestTorrent' => $bestTorrent,
                'season' => $season,
                'episode' => $episode,
                'url' => $url,
            )
        );
    }

    /**
     * @param string $serie
     * @param string $season
     * @param string $episode
     * @param string $fullNameSerie
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getSubtitleLinksAction($serie, $season, $episode, $fullNameSerie)
    {
        $subtitles = $this->get('fabex_app.provider.subtitle')->getSubtitle($serie, $season, $episode, $fullNameSerie);

        return $this->render(
            'FabexAppBundle:Default:getSubtitleLinks.html.twig',
            array('subtitles' => $subtitles)
        );
    }

    /**
     * @param string $serie
     * @param string $season
     * @param string $episode
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function toggleDownloadedEpisodeAction($serie, $season, $episode)
    {
        $this->get('fabex_app.manager.serie')->toggleDownloadedEpisode($serie, $season, $episode);

        return new JsonResponse('ok');
    }

    /**
     * @param string $serie
     * @param string $season
     * @param string $episode
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function watchedEpisodeAction($serie, $season, $episode)
    {
        $this->get('fabex_app.manager.serie')->watchedEpisode($serie, $season, $episode);

        return new RedirectResponse($this->get('router')->generate('fabex_app_homepage'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function subtitleLink(Request $request)
    {

        return new JsonResponse('ok');
    }
}
