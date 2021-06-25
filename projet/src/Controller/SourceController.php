<?php

namespace App\Controller;

use DateTime;
use App\Entity\Source;
use App\Form\NewSourceType;

use App\Repository\SourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Time;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SourceController extends AbstractController
{

    private $repository;

    public function __construct(SourceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/ajoutSource", name="ajoutSource")
     */
    public function createSource(Request $request, EntityManagerInterface $manager)
    {
        $source = new Source();

        $form = $this->createForm(NewSourceType::class, $source);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $source->setCreatedAt(new \DateTimeImmutable());
            $source->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($source);
            $manager->flush();

            return $this->redirectToRoute('source');

        }

        return $this->render('formulaire.html.twig', array(
            'controller_name' => 'SourceController',
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}",defaults={"id" = null}, name="source")
     */
    public function index($id): Response
    {
        if ($id == null) {
            #Récupération du flux RSS 
            $rss = simplexml_load_file('http://www.lemonde.fr/rss/une.xml');
            $name = "Le monde";
        }
        else {
            $infoId = $this->repository->getInfos($id);
            $rss = simplexml_load_file($infoId[0]->getUrlSource());
            $name = $infoId[0]->getNomSource();
        }

        #Récupération des informations en BDD 
        $allSources = $this->repository->getAllInfos();

        return $this->render('source/index.html.twig', array(
            'rssItems' => $rss->channel->item,
            'sources' => $allSources,
            'nom_flux' => $name,
            'controller_name' => 'SourceController'
        ));
    }

}