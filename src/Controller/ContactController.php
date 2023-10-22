<?php

namespace App\Controller;

use App\Entity\Contacts;
use App\Entity\User;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['id'=>$this->getUser()->getId()]);
        $contact = new Contacts();
        $form = $this->createForm(ContactType::class, $contact);
        $contacts = $em->getRepository(Contacts::class)->findBy(['user'=>$user]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setUser($user);
            $em->persist($contact);
            $em->flush();
            $this->addFlash('success', 'New Contact Created Successfully.');
            return $this->redirectToRoute('contact');
        }
        if($request->isXmlHttpRequest()){
            $data = $request->request->get('data');
            parse_str($data, $params);
            $contactObject = (array) $params;
            $contactobj = $em->getRepository(Contacts::class)->findOneBy(['id'=>$contactObject['contact_id']]);
            $contactobj->setTitle($contactObject['title']);
            $contactobj->setFirstname($contactObject['firstname']);
            $contactobj->setLastname($contactObject['lastname']);
            $contactobj->setEmail($contactObject['email']);
            $contactobj->setContactnumber($contactObject['contactnumber']);
            $contactobj->setaddress($contactObject['address']);
            $contactobj->setUser($user);
            $em->persist($contactobj);
            $em->flush();
            $this->addFlash('success', 'Contact Updated Successfully.');
            return new JsonResponse('success',200);
        }
        return $this->render('contact/contact.html.twig', ['form' => $form->createView(),'contacts'=>$contacts]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->redirectToRoute('app_login');
    }


    /**
     * @Route("/deletecontact/{id}", name="deletecontact")
     */
    public function deletecontact($id)
    {
        $em = $this->getDoctrine()->getManager();
        $contactobj = $em->getRepository(Contacts::class)->findOneBy(['id'=>$id]);
        $em->remove($contactobj);
        $em->flush();
        $this->addFlash('error', 'Contact Deleted Successfully.');
        return $this->redirectToRoute('contact');
    }




}