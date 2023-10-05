<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Entity\Login;
use App\Repository\LoginRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;  //submittype form

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/register', name: 'register.')]
class RegistrationController extends AbstractController
{
    #[Route('/create', name: 'create')] //, methods: ['GET', 'POST']
    public function register(ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher, Request $request): Response
    {
      /* not using LoginType.php */  
      $Registerform = $this->createFormBuilder()
       ->add('username')
       ->add('password', RepeatedType::class, [
            'type'=> PasswordType::class,
            'required' => true,
            'first_options'=>['label' => 'Password'],
            'second_options' => ['label' => 'Confirm Password']
        ])
       ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'required' => true,
            'first_options' => ['label' => 'password'],
            'second_options' => ['label' => 'confirm password']
        ])
        ->add('Register', SubmitType::class
            ,[
            'attr' => ['class' => 'btn btn-success front-end']
        ]) 
        ->getForm()
        ;
         /*  */
        /* if using LoginType.php 
        $login = new Login();
        $form = $this->createForm(LoginType::class, $login);
        */ 
        $Registerform->handleRequest($request);
      
    
        if($Registerform->isSubmitted()){
            /* if  Not using LoginType.php */
            $data  =  $Registerform->getData();

            $login = new Login();
            $login->setUsername($data['username']);
            $hashedPassword =  $passwordHasher->hashPassword($login, $data['password']);
            $login->setPassword($hashedPassword);

            /**  */
            /* If using loginType.php 
            $hashedPassword =  $passwordHasher->hashPassword($login, $login->getPassword());
            $login->setPassword($hashedPassword);
             */
            $em = $doctrine->getManager();
            $em->persist($login);
            $em->flush();
            $this->addFlash('loginsuccess',
            'LoginUser '.$login->getusername().' has been added for a role successfully');
            //$this->render('user/user.html.twig',['username' => $login->getusername()]);
            //return $this->redirect($this->generateUrl(route: 'welcome', parameters:['name'=>$login->getusername()])); //need to pass variable
            //return $this->redirect($this->generateUrl(route:'app_login')); 
            return $this->redirectToRoute('app_login');

            //return $this->redirect($this->generateUrl(route:'signin')); 


        }
        
        return $this->render('registration/index.html.twig', [
            'Registerform' => $Registerform->createView()
        ]);
    }
}
