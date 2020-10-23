<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;

class PropertyController extends AbstractController
{


    /**
     * @var PropertyRepository
     */

    private $propertyRepository;

    public function __construct(PropertyRepository $propertyRepository)
    {
        $this -> repository = $propertyRepository;        
    }


    /**
     * @Route("/biens", name="biens")
     */
    public function index(PropertyRepository $propertyRepository)
    {
        /*                                      Code d'insert;
        $property = new Property();                             Je crée une nouvelle propriété
        $property ->setTitle('Mon premier bien')                Je défini les valeurs de cet proprité
                ->setPrice(200000)
                ->setRooms(4)
                ->setBedrooms(3)
                ->setDescription('Une petite description')
                ->setSurface(60)
                ->setFloar(4)
                ->setHeat(1)
                ->setCity('Montpellier')
                ->setAdress('15 rue de Gambetta')
                ->setPostalCode(34000)
                ;

                $em = $this -> getDoctrine()->getManager();     J'utilise doctrine et le manager pour envoyer en bd
                $em -> persist($property);
                $em -> flush();
        */


       /*       Pour select avec ce que je souhaite en parametre (Where)
       
       $property = $this->repository->findOneBy(['floar' => 4]);
        dump($property);

        */ 
        
        $properties = $propertyRepository->findAllVisible();
        //$property[0]->setSold(true);

        //$this->getDoctrine()->getManager()->flush();
        
        return $this->render('property/index.html.twig', [
            'properties' => $properties
        ]);
    }
    /**
     * @Route ("/biens/{slug}-{id}", name="property_show", requirements={"slug": "[a-z0-9\-]*"})
     * @return response
     */
    public function show($slug, Property $property)
    {
        if ($property->getslug() !== $slug) 
        {
           return $this->redirectToRoute('property_show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ] , 301 );

        }
        return $this->render('property/show.html.twig', [
            'property' => $property            
        ]);
    }
}
