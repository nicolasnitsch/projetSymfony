<?php

namespace TWA\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TWA\BlogBundle\Entity\Article;
use TWA\BlogBundle\Form\ArticleType;

class ArticleController extends Controller

{
    public function addAction(Request $request)
    {
        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $entityRepository = $entityManager->getRepository("TWABlogBundle:Article");
        $formFactory = $this->get("form.factory");
        #creation d'un objet vide
        $articleObject = new Article();

        $form = $formFactory->create(new ArticleType(), $articleObject);
        $articleForm = $form->createView();

        if ($form->handleRequest($request)->isValid())
        {
            print_r($articleObject);
            #on voit que tout est rempli
            $entityManager->persist($articleObject);
            #persist est une sorte de prepare. On peut persister plusieurs chose des suite
            #persist va faire gérer $entityManager par doctrine
            #doctrine transforme l'objet, et l'envoie à pdo qui l'enregistre en BDD
            $entityManager->flush();
            #flush commande l'exécution des persist à Doctrine
            $this->redirect($this->generateUrl('twa_ab_dashboard'));
        }

        $renderedView = $this->render('TWAAdminBundle:Article:form.html.twig', array('articleForm' => $articleForm));
        return($renderedView);

    }

    public function deleteAction ($articleId)
    {
        $entityManager = $this
            ->getDoctrine()
            ->getManager()
        ;
        #on fait une requete entity repository car c'est un select

        $entityRepository = $entityManager->getRepository('TWABlogBundle:Article');
        $articleObjectToDelete = $entityRepository->find($articleId);

        //print_r($articleObjectToDelete);
        //echo(__NAMESPACE__); cet echo permet d'afficher le namespace à l'écran


        if (!$articleObjectToDelete)
        {
            throw $this->createNotFoundException("l'id de l'article que vous voulez supprimer n'a pas été trouvé");
            #particularité : pas besoin de faire else car si il y a eu une exception, cela interrompt
            #le programme

        }

        $entityManager->remove($articleObjectToDelete);
        $entityManager->flush();
        //pour générer l'url d'une route dans le controller, c'est la même chose
        //que le header location
        return $this->redirect($this->generateUrl('twa_bb_articles_list'));
        //



    }






}