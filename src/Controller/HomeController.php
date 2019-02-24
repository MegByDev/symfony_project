<?php

namespace App\Controller;

use Repository\Environment;
use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    
    /**
     * @Route("/home" name="home")
     */

    private $repository;
    
        public function __construct(PropertyRepository $repository)
        {  
            $this->repository = $repository;
        }
        
    
        public function index(): Response
        {

           // $entityManager = $this->getDoctrine()->getManager();
            $properties = $this->repository->findLatest();
            //dump($properties);
            

        return $this->render('pages/home.html.twig', 
        [
            'properties' => $properties
        ]);
    }
}
