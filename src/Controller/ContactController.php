<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @IsGranted("ROLE_USER")
 */
class ContactController extends AbstractController
{

    /**
     * @Route("/contact/information/list", name="contact")
     */
    public function contactlist(Request $request)
    {
        return $this->render('contact/contact.html.twig');
    }


}