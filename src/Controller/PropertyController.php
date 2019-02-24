<?php
namespace App\Controller;

use Repository\Environement;
use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//À l'intérieur du contrôleur, vous pouvez créer un nouvel Productobjet, y définir des données et le sauvegarder!
class PropertyController extends AbstractController
{
    //Récupérer un objet en dehors de la base de données est encore plus facile. Supposons que vous souhaitiez aller /property/1 voir votre nouveau propriété:

     /**
     * @Route("/property" , name="property.index")
     */

    private $repository;

    public function __construct(PropertyRepository $repository)
    {  
        
        $this->repository = $repository;
  
    }
    /**
     * @Route("/biens", name="biens")
     * @return Response
     */

    public function index(): Response
    {
        //$entityManager = $this->getDoctrine()->getManager();
        //$properties = $entityManager->getRepository(property::class)->findAllVisible();
        //dumb($properties);
        // $property[0]->setSold(true);
        // $property = new Property();
        
        // $entityManager->persist($property);

        // // $entityManager->flush();

        // // $property = $this->$twig->find($id);   
    
        // dump($property);
 
        return $this->render('property/index.html.twig', 
        [
        'current_menu' => "properties"

        ]);
    }

     /**
     * @Route("biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"}) )
     * @param Property $property
     * @return Response
     */

     public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug)
        {
            return $this->redirectToRoute('property.show', [
                'id' => $property ->getId(),
                'slug' => $property ->getSlug()
            ], 301);
        }
        return $this->render('property/show.html.twig', [
           
            'property' => $property,
            'current_menu' => "properties"
        ]);
    } 
}