<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngredientController extends AbstractController
{
    /**
     * @Route("/ingredient", name="ingredient")
     */
    #[Route('/ingredient', name: 'app_ingredient')]
    public function index(IngredientRepository $ingredientRepository, PaginatorInterface $paginator, Request $request)
    {
        $query =  $ingredientRepository->findAll();

        $ingredients = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/ingredient/index.html.twig', [
            'ingredients' => $ingredients ,
        ]);
    }

    #[Route('/ingredient/new', name: 'app_ingredient_new', methods: ['GET', 'POST'])]
    public function new(Request  $request, EntityManagerInterface $manager)
    {
        $ingredient = new Ingredient();
        $form  = $this->createForm(IngredientType::class, $ingredient );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $ingredient = $form->getData();
            $manager->persist($ingredient);
            $manager->flush();

            $this->addFlash('success', 'L\'ingrédient a bien été ajouté') ;
             return $this->redirectToRoute('app_ingredient');
        }

        return $this->render('pages/ingredient/new.html.twig', ['form' => $form->createView()]);
    }


    /*
    * This method is not used in the project
    */

    #[Route('/ingredient/edit/{id}', name: 'app_ingredient_edit', methods: ['GET', 'POST'])]
    public function edit (Ingredient  $ingredient,
                          Request  $request,
                          EntityManagerInterface $manager)
    {
        $form  = $this->createForm(IngredientType::class, $ingredient );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() )
        {
            $ingredient = $form->getData();
            $manager->persist($ingredient);
            $manager->flush();

            $this->addFlash('success', 'L\'ingrédient a bien été modifié') ;
            return $this->redirectToRoute('app_ingredient');

        }

        return $this->render('pages/ingredient/edit.html.twig', ['form' =>$form->createView()]);
    }


    #[Route('/ingredient/delete/{id}', 'app_ingredient_delete', methods: ['GET', 'POST'])]
    public function delete(EntityManagerInterface  $manager,
                           Ingredient $ingredient){
        if($ingredient)
        {
           $manager->remove($ingredient);
           $manager->flush();

           $this->addFlash('success', 'L\'ingrédient a bien été supprimé') ;

           return $this->redirectToRoute('app_ingredient');
        }
    }




}
