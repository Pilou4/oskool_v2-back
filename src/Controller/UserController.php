<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserCreateType;
use App\Form\UserPasswordUpdateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/user")
 */

class UserController extends AbstractController
{
    /**
     * @Route("/create-account", name="user_account_create")
     */
    public function createAccount(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserCreateType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $plainPassword = $form->get('password')->getData();
            $encodedPassword = $passwordEncoder->encodePassword($user, $plainPassword);
            $user->setPassword($encodedPassword);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash("succes", "Votre compte à bien été crée ! Merci de vous authentifier.");
            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/create-account.html.twig',
            [
                "form" =>
                $form->createView()
            ]
        );
    }

      /**
     * @Route("/change-password", name="user_password_change")
     *
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder) 
    {
       
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(UserPasswordUpdateType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $plainPassword = $form->get('newPassword')->getData();
            $encodedPassword = $passwordEncoder->encodePassword($user, $plainPassword); 
            $user->setPassword($encodedPassword);

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Le mot de passe à bien été modifié");
            return $this->redirectToRoute("homepage");
        }
        
        return $this->render(
            'user/change-password.html.twig',
            [
                "form" => $form->createView()
            ]
        );
    }

}
  

