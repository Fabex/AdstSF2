<?php

namespace Fabex\Bundle\AdstBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $betaserie = $this->get('fabex_beta_serie.betaserie');
        $episodes = $betaserie->memberLastEpisode();

        return $this->render('FabexAdstBundle:Default:index.html.twig', array('episodes' => $episodes));
    }

    public function watchedAction($serie, $season, $episode)
    {
        $betaserie = $this->get('fabex_beta_serie.betaserie');
        $betaserie->episodeWatched($serie, $season, $episode);

        return $this->redirect($this->generateUrl('fabex_adst_homepage'));
    }

    public function downloadedAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $serie = $request->request->get('serie');
            $season = $request->request->get('season');
            $episode = $request->request->get('episode');

            $betaserie = $this->get('fabex_beta_serie.betaserie');
            $betaserie->episodeDownloaded($serie, $season, $episode);
        }

        return new Response();
    }
}
