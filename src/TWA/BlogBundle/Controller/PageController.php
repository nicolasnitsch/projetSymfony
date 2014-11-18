<?php

namespace TWA\BlogBundle\Controller;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller

{
    public function indexAction()

    {
        $renderedView = $this->render("TWABlogBundle:Page:home.html.twig");
        return $renderedView;


    }

public function contactAction()
{
    $renderedView = $this->render("TWABlogBundle:Page:contact.html.twig");
    return $renderedView;

}

}