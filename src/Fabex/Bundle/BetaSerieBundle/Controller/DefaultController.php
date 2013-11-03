<?php

namespace Fabex\Bundle\BetaSerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FabexBetaSerieBundle:Default:index.html.twig', array('name' => $name));
    }
}
