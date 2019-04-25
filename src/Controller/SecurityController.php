<?php

namespace App\Controller;

use App\Entity\Pig;
use App\Form\Pig1Type;
use App\Form\PigType;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController {

    /**
     * @Route("/security", name="security")
     */
    public function index() {
        return $this->render('security/index.html.twig', [
                    'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils) {

        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', array("error" => $error, "username" => $lastUsername));
    }
    
     /**
     * @Route("/{id}", name="security_edit", requirements={"id":"\d+"})
     */
    public function edit(Pig $pig,AuthenticationUtils $authenticationUtils,Request $request,UserPasswordEncoderInterface $encoder, ObjectManager $manager) {

        
        $form = $this->createForm(PigType::class, $pig);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pig->setCreatedAt(new DateTime());
            $hash = $encoder->encodePassword($pig, $pig->getPassword());
            $pig->setPassword($hash);
           
            $pig->setUsername( $pig->getPseudoName());
            $manager->persist($pig);
            $manager->flush();
            return $this->redirectToRoute('security_login');
        }
        return $this->render('security/edit.html.twig', [
                    'pig' => $pig,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout() {
        return $this->render('security/login.html.twig', [
                    'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/subscribe", name="security_subscribe")
     */
    public function subscribe(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {
        $pig = new Pig();
        $form = $this->createForm(PigType::class, $pig);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pig->setCreatedAt(new DateTime());
            $hash = $encoder->encodePassword($pig, $pig->getPassword());
            $pig->setPassword($hash);
           
            $pig->setUsername( $pig->getPseudoName());
            $manager->persist($pig);
            $manager->flush();
            return $this->redirectToRoute('security_login');
        }
        return $this->render('security/subscribe.html.twig', [
                    'pigForm' => $form->createView(),
        ]);
    }

}
