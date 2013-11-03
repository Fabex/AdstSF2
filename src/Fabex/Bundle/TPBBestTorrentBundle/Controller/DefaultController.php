<?php

namespace Fabex\Bundle\TPBBestTorrentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function getBestTorrentAction(Request $request)
    {
        $serie = $request->request->get('serie');
        $number = $request->request->get('number');

        $tpb = $this->get('fabex_tpb_best_torrent.tpb');
        $url = $tpb->getTorrent($serie, $number);

        return $this->render('FabexTPBBestTorrentBundle:Default:index.html.twig', array('url'=>$url));
    }
}
