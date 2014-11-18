<?php

namespace TWA\AdminBundle\Controller;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//Pas besoin de faire un use appelant TWABlogBundle, car la route est précisée dans le getRepository


class PageController extends Controller

{
    public function dashBoardAction ()
    {

        $entityManager = $this
            ->getDoctrine()
            ->getManager()
        ;
        #on fait une requete entity repository car c'est un select

        $entityRepository = $entityManager->getRepository('TWABlogBundle:Article');

        $articlesList = $entityRepository->listByDateDesc();

        $renderedView = $this->render('TWAAdminBundle:Page:dashboard.html.twig', array(
            'articlesList' => $articlesList

        ));

        return $renderedView;
    }


}