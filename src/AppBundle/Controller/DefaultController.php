<?php

namespace AppBundle\Controller;
//namespace AppBundle\Entity;

use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use AppBundle\Entity\Utente;
use AppBundle\Form\UtenteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     */
      public function indexAction(Request $request)
    {


        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/users/new", name="users_new")
     */
    public function createUserAction(Request $request)
    {
       $user= new User();
       $form=$this->createForm(UserType::class,$user);
       $form->handleRequest($request);
       if($form->isValid() && $form->isSubmitted())
       {
           $em=$this->getDoctrine()->getManager();

           /**
            * @var $file UploadedFile
            */
           $file= $user->getAvatar();
           $fileName=md5(uniqid()).'.'.$file->guessExtension();
           $file->move($this->getParameter('upload_dir'),$fileName);
           $user->setAvatar($fileName);
           $em->persist($user);
           $em->flush();
           return $this->redirectToRoute('homepage');
       }


        return $this->render('default/users.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        'form'=> $form->createView()]
        );
    }
    /**
     * @Route("/users", name="salutando")
     *
     */
    public function salutaAction(Request $request)
    {


        return $this->render('default/saluta.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    /**
     * @Route("/form", name="visualizzaform")
     *
     */
    public function formAction(Request $request)
    {
        $utente= new Utente();
        $form= $this->createForm(UtenteType::class,$utente);


        return $this->render('default/form.html.twig', ['form'=>$form->createView()

        ]);
    }

}
