<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Property;
use App\Form\PropertyType;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class AdminPropertyController extends AbstractController
{
    

    private $propertyRepository;

    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;     
        
    }

    /**
     * @Route("/admin/", name="admin_property_index")
     */
    public function index()
    {
        $properties = $this->propertyRepository->findAll();

        return $this->render('admin_property/index.html.twig', [
            'controller_name' => 'AdminPropertyController',
            'properties' => $properties
        ]);
    }

    /**
     * @Route("/admin/property/create", name="admin_property_new")
     */
    public function new(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($property);

            $em->flush();
            return $this->redirectToRoute('admin_property_index');
        }

        return $this->render('admin_property/new.html.twig', [
            'controller_name' => 'AdminPropertyController',
            'property' => $property,
            'form' => $form->createView()
        ]);

    
    }

    /**
     * @Route("/admin/property/{id}/", name="admin_property_edit", methods={"GET","POST"})
     */
    public function edit(Property $property, Request $request)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            

            $em = $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Bien modifié');
            return $this->redirectToRoute('admin_property_index');
        }

        return $this->render('admin_property/edit.html.twig', [
            'controller_name' => 'AdminPropertyController',
            'property' => $property,
            'form' => $form->createView()
        ]);    
    }
    /**
     * @Route ("/admin/property/{id}/delete", name="admin_property_delete", methods={"DELETE"})
     * @param Property $property
     */
    public function delete(Property $property, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
           
            $em = $this->getDoctrine()->getManager();

            $em->remove($property);
            $em->flush();

        }
       

       return $this->redirectToRoute('admin_property_index');
    }
}
