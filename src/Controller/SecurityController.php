<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgotPasswordType;
use App\Form\RegisterType;
use App\Manager\MailManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('contact');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/register",name="register")
     */
    public function registerAction(Request $request,MailManager $mailManager,UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($userPasswordEncoder->encodePassword($user, $form->get('plainpassword')->getData()));
            $em->persist($user);
            $user->setRoles(['ROLE_USER']);
            $em->flush();
            $mailManager->registerEmail($user);
            return $this->redirectToRoute('app_login');
        }
        return $this->render('register/register.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/forgotpassword", name="forgotpassword")
     */
    public function forgotPasswordEmail(Request $request, EntityManagerInterface $entityManager, MailManager $mailManager): Response
    {
        $email = $request->query->get('email');
        if($email) {
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
            if ($user) {
                $mailManager->forgotPasswordEmail($user);
                $this->addFlash("success","Reset password link sent to your email");
                return $this->redirectToRoute('forgotpassword');
            }else{
                $this->addFlash("failed","User not found, enter valid Email");
                return $this->redirectToRoute('forgotpassword');
            }
        }
        return $this->render('forgotpassword.html.twig');
    }

    /**
     * @Route("/resetpassword/{id}", name ="resetpassword")
     */
    public function resetpassword(Request $request, $id, UserPasswordEncoderInterface $userPasswordEncoder, EntityManagerInterface $entityManager)
    {

        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        if($user){
            $form = $this->createForm(ForgotPasswordType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user->setPassword($userPasswordEncoder->encodePassword($user, $form->get('plainpassword')->getData()));
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('success', 'Password Updated Successfully');
                return $this->redirectToRoute('app_login');
            }
            return $this->render('resetpassword.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        $this->addFlash('error', 'User not found');
        return $this->redirectToRoute('app_login');

    }

    /**
     * @Route("/verifyaccount/{id}", name="verifyaccount")
     */
    public function verifyaccount($id, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['id'=>$id]);
        if ($user){
            $user->setIsverified(true);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Account verified');
        }else{
            $this->addFlash('error', 'User not found');
        }
        return $this->redirectToRoute('app_login');
    }
}
