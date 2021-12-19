<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Rubriques;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/{id}", name="category_index", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository, $id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repo->findBy(array('rubrique_id' => $id));
        return $this->render('category/index.html.twig', ['categories' => $categories, 'id' => $id]);
    }

    /**
     * @Route("/new/{id}", name="category_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        $repo = $this->getDoctrine()->getRepository(Rubriques::class);
        $rubrique = $repo->find($id);
        $category->setRubriqueId($rubrique);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
            $repo = $this->getDoctrine()->getRepository(Category::class);
            $categories = $repo->findBy(array('rubrique_id' => $id));
            return $this->render('category/index.html.twig', ['categories' => $categories, 'id' => $id]);
        }

        return $this->renderForm('category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="category_show", methods={"GET"})
     */
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="category_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id1}/{id2}", name="category_delete")
     */
    public function delete_category($id1,$id2): Response
    {   $repo = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repo->find($id2);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($categories);
        $manager->flush();
        $repo = $this->getDoctrine()->getRepository(Category::class);
        $categories1 = $repo->findBy(array('rubrique_id' => $id1));
        return $this->render('category/index.html.twig', ['categories' => $categories1, 'id' => $id1]);
    }
}
