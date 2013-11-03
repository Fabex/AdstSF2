<?php

namespace Fabex\Bundle\SubTitleProviderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function getSubTitleAction(Request $request)
    {
//        if ($request->isXmlHttpRequest()) {
            $serie = $request->request->get('serie', 'touch-2011');
            $fullNameSerie = $request->request->get('fullNameSerie', 'House of Cards (2013)');
            $season = $request->request->get('season', '1');
            $episode = $request->request->get('episode', '6');

            $subtitle = $this->get('fabex_sub_title_provider.subtitle');
            $srts = $subtitle->getSubTitle($serie, $fullNameSerie, $season, $episode);
            return $this->render('FabexSubTitleProviderBundle:Default:index.html.twig', array('srts' => $srts));
//        }

        return $this->createNotFoundException();



    }
}
