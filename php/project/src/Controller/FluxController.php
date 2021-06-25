<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FluxController extends AbstractController
{
    /**
     * @Route("/", name="flux")
     */
    public function index(): Response
    {
        $rss = simplexml_load_file('http://www.lemonde.fr/rss/une.xml');
        return $this->render('flux/index.html.twig', array(
            'rssItems' => $rss->channel->item,
            'controller_name' => 'FluxController'
        ));
    }
}
