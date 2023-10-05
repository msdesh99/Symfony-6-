<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\DepartmentRepository;
use App\Services\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\String\Slugger\SluggerInterface; 
use Symfony\Component\HttpFoundation\File\Exception\FileException;



//php bin/console debug:router : to see existing routers;
#[Route('/user', name: 'user.')]

class UserController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        //dump($users);
        return $this->render('user/index.html.twig', [
            'users' =>$users
            //'controller_name' => 'UserController',

        ]);
    }
    #[Route('/category', name: 'category')]
    public function category(DepartmentRepository $departmentRepository): Response
    {
        $departments = $departmentRepository->findAll();
        //
        dump($departments);
        return $this->render('user/category.html.twig', [
            'departments' =>$departments
            //'controller_name' => 'UserController',

        ]);
    }

    #[Route('/create', name: 'createUser')]
    //public function createUser(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger){
    public function createUser(ManagerRegistry $doctrine, Request $request, FileUploader $FileUploader){

        
        $user = new User();
        /*$user->setusername('Meenakshi Deshpande');
        $user->setemail('abc@xyz.com');
        $user->setuserid(100); */
        //create form instance 
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $form->getErrors();
    
        if ($form->isSubmitted() && $form->isValid()) { 
            //dump($request->files);
            //for avatar: https://www.google.com/search?q=+mvc+symfony+framework+tutorial&rlz=1C1CHBF_enIN926IN927&biw=1280&bih=569&tbm=vid&sxsrf=APwXEdd2Jeqg_6NLXC4GLiD9HOsMJ7dp3w%3A1683830677400&ei=lTddZJ31F46oqtsP34-CoA0&ved=0ahUKEwjdk42L9u3-AhUOlGoFHd-HANQQ4dUDCA0&uact=5&oq=+mvc+symfony+framework+tutorial&gs_lcp=Cg1nd3Mtd2l6LXZpZGVvEAMyCAghEBYQHhAdMggIIRAWEB4QHTIICCEQFhAeEB06BAgjECc6BwgjELACECc6BQgAEKIEOgoIIRCgARDDBBAKOgcIIRCgARAKOgYIIRANEBVQhQhY1GVgumhoAHAAeACAAZQBiAGcFJIBBDMuMjCYAQCgAQHAAQE&sclient=gws-wiz-video#fpstate=ive&vld=cid:07975e4d,vid:Bo0guUbL5uo
            $avatarFile = $request->files->get('user')['avatar']; 
          
            //for attach: https://symfony.com/doc/current/controller/upload_file.html#creating-an-uploader-service
            $profileFile = $request->files->get('user')['attachment'];

            //dump($this->getParameter('uploads_dir'));

            // this condition is needed because the 'attachment','userImage' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($avatarFile){
                //Thin controller Fat Model design
                $avatarfilename = $FileUploader->uploadYouTube($avatarFile);
                /*$avatarfilename = md5(uniqid()). '.' .$avatarFile->guessClientExtension();
                
                $avatarFile->move(
                    $this->getParameter('uploads_dir'), //parameters defined in services.yaml
                    $avatarfilename
                );*/  
            } 
            if($profileFile){
                $newFilename = $FileUploader->upload($profileFile);
                /*
                $originalFilename = pathinfo($profileFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$profileFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try{
                    $profileFile->move(
                        $this->getParameter('uploads_dir'),
                        $newFilename
                    );
                } catch (FileException $e){
                   // ... handle exception if something happens during file upload
                }    */
            
            }
            $user->setAvatar($avatarfilename);
            $user->setAttach($newFilename);
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();
            $this->addflash('success', 'User ID'.$user->getid().'Name: '.$user->getusername().' Added Successfully');
            return $this->redirect($this->generateUrl(route:'user.index'));
        }
        //dump($user);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        // actually executes the queries (i.e. the INSERT query)
        
        //return new Response('User has been created');
        /*return $this->render('base.html.twig', [
            'title' => 'User has been created'
        ]); */
       // return $this->render('user/index.html.twig');  runtime error: Variable "users" does not exist.
       //return $this->redirect($this->generateUrl(route:'user.index')); commented as form added
       
       return $this->render('user/create.html.twig',[
            'form' => $form->createView()
        ]);


    }
    #[Route("/show/{id}", name: "show")]
    //public function show($id, UserRepository $repo){
        //$user = $repo->find($id);  
     //replace above 2 lines with 
    public function show(user $user){
        //dump($user);
        return $this->render('user/show.html.twig', [
            'user' =>$user
        ] );
    }
    #[Route("/showByCategory/{CategoryId}", name:"showByCategory")]
    public function showByCategory($CategoryId, UserRepository $userRepository){
        $users = $userRepository->FindByCategory($CategoryId);  
        //dump($users);
        return $this->render('user/index.html.twig', [
            'users' =>$users
        ] );
    }

    #[Route("/remove/{id}", name: "remove")]
    public function remove(ManagerRegistry $doctrine, user $user){
        $em = $doctrine->getManager();
        $username = $user->getusername();
        $em->remove($user);
        $em->flush();
        
        $this->addFlash('success','User : ' .$username.' is deleted successfully');
        
        return $this->redirect($this->generateUrl(route:'user.index'));
        //1st: return new Response(content:"User :" .$username." is deleted successfully");
        /*return $this->render('base.html.twig',[
            'title' => 'User : ' .$username.' is deleted successfully'
        ]);*/ 

    }
}
