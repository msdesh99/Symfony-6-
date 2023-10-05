<?php
namespace App\Controller;

//require  'c:\wamp64\www\myproject8.2\vendor\Symfony\Framework-Bundle\Controller\AbstractController.php';

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController  extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index() {
        return $this->render(view:'/home/home.html.twig');  //sf5
    }
    /*public function index(): JsonResponse
    {   return $this->json([
            'message' => dirname(__DIR__). 'dir: '. __DIR__. ' Welcome to your myproject8.2 new controller!',
            'path' => 'src/Controller/MainController.php',
        ]);
    } */

    #[Route('/custom', name: 'update')]
    public function update() {
       return $this->render('custom/custom.html.twig'); 
       //return new Response(content:'<h1>This is Custom Page</h1');
    }
    
    
    /**
     * @Route('/user/{name?}, name:'welcome')
     * @param Request $request
     * @return Response
     */
     
    #[Route('/loginuser/{name?}', name:'welcome')]
    //#[param Request $request]
    //#[return Response]

    public function login(Request $request){
        //dump($request->get(key:'name'));
        $name = $request->get(key:'name');
        return $this->render('user/user.html.twig', ['username' => $name ]);
        //return new Response(content:'<h1>Welcome User:' . $name .' !</h1>');
    }
   #[Route('/signin', name:'signin')]
   public function signin(){
     return $this->render('security/signin.html.twig');
   }
}
  