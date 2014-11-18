<?php

namespace TWA\BlogBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\component\httpFoundation\Request;
use TWA\BlogBundle\Entity\Article;
use TWA\BlogBundle\Form\ArticleType;

class ArticleController extends Controller
{
    public function showAction ($articleId)
    {


        #on veut désormais afficher l'article créé
        #il y a un chainage de méthodes
        # on a récupéré un objet qui peut utiliser toutes les méthodes du repository
        # et on hérite d'une classe

        $entityRepository = $this
            ->getDoctrine()
            ->getMAnager()
            ->getRepository('TWABlogBundle:Article')
        ;

        $articleObject = $entityRepository->findOneByArticleId($articleId);
        #Generation de méthode à la volée
        if(!$articleObject)
        #équivalent à $is_null($articleObject)
        {
            throw $this->createNotFoundException("l'article d'Id ".$articleId. " n'existe pas");

        }
        # ceci est un message d'erreur affichée pour le développeur.
        #Elle n'apparait pas comme telle en production
        #pour l'internaute. Pour l'envoyer à la views:


        print_r($articleObject);

        $renderedView = $this->render ('TWABlogBundle:Article:article.html.twig', array("article"=>$articleObject));

        #Attention ici 'articleId' est le nom de la variable locale, ce n'est pas la valeur de l'id


        return $renderedView;
        #il faut retourner le $RenderedView au Kernel qui l'envoie au client

    }


    public function listAction ()
    {

        $entityManager = $this
            ->getDoctrine()
            ->getManager()
        ;
        #on fait une requete entity repository car c'est un select

        $entityRepository = $entityManager->getRepository('TWABlogBundle:Article');

        $articlesList = $entityRepository->listByDateDesc();

        $renderedView = $this->render('TWABlogBundle:Article:articles.html.twig', array(
            'articlesList' => $articlesList
        ));

        return $renderedView;
    }


}
