<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Depots;
use App\Form\DepotsType;
use App\Repository\DepotsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/depots")
 */
class DepotsController extends AbstractController
{
    /**
     * @Route("/{id}", name="depots_index", methods={"GET"})
     */
    public function index(DepotsRepository $depotsRepository, $id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Depots::class);
        $depots = $repo->findBy(array('category_id' => $id),array('NbLikes' => 'DESC'));
        return $this->render('depots/index.html.twig', ['depots' => $depots, 'id' => $id]);
    }

    /**
     * @Route("/new/{id}", name="depots_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $depot = new Depots();
        $form = $this->createForm(DepotsType::class, $depot);
        $form->handleRequest($request);
        $repo = $this->getDoctrine()->getRepository(Category::class);
        $category = $repo->find($id);
        $depot->setCategoryId($category);
        $depot->setNbLikes(0);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($depot);
            $entityManager->flush();
            $repo = $this->getDoctrine()->getRepository(Depots::class);
            $depots = $repo->findBy(array('category_id' => $id),array('NbLikes' => 'DESC'));
            return $this->render('depots/index.html.twig', ['depots' => $depots, 'id' => $id]);
        }

        return $this->renderForm('depots/new.html.twig', [
            'depot' => $depot,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="depots_show", methods={"GET"})
     */
    public function show(Depots $depot): Response
    {
        return $this->render('depots/show.html.twig', [
            'depot' => $depot,
        ]);
    }

    /**
     * @Route("/{id}/edit/{id1}", name="depots_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Depots $depot, EntityManagerInterface $entityManager, $id1): Response
    {
        $form = $this->createForm(DepotsType::class, $depot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $repo = $this->getDoctrine()->getRepository(Depots::class);
            $depos1 = $repo->findBy(array('category_id' => $id1),array('NbLikes' => 'DESC'));
            return $this->render('depots/index.html.twig', ['depots' => $depos1, 'id' => $id1]);
        }

        return $this->renderForm('depots/edit.html.twig', [
            'depot' => $depot,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/delete/{id1}/{id2}", name="depots_delete")
     */
    public function delete_category($id1, $id2): Response
    {
        $repo = $this->getDoctrine()->getRepository(Depots::class);
        $depots = $repo->find($id2);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($depots);
        $manager->flush();
        $repo = $this->getDoctrine()->getRepository(Depots::class);
        $depos1 = $repo->findBy(array('category_id' => $id1),array('NbLikes' => 'DESC'));
        return $this->render('depots/index.html.twig', ['depots' => $depos1, 'id' => $id1]);
    }
}
