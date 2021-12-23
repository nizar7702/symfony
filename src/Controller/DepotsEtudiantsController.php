<?php

namespace App\Controller;

use App\Entity\ContenuDepot;
use App\Entity\DepotsEtudiants;
use App\Form\DepotsEtudiantsType;
use App\Repository\DepotsEtudiantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/depots/etudiants")
 */
class DepotsEtudiantsController extends AbstractController
{
    /**
     * @Route("/{id}", name="depots_etudiants_index", methods={"GET"})
     */
    public function index(DepotsEtudiantsRepository $depotsRepository, $id): Response
    {
        $repo = $this->getDoctrine()->getRepository(DepotsEtudiants::class);
        $depotsEtudiants = $repo->findBy(array('contenu_depot_id' => $id));
        return $this->render('depots_etudiants/index.html.twig', ['depots_etudiants' => $depotsEtudiants, 'id' => $id]);
    }

    /**
     * @Route("/new/{id}", name="depots_etudiants_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $depotsEtudiants = new DepotsEtudiants();
        $form = $this->createForm(DepotsEtudiantsType::class, $depotsEtudiants);
        $form->handleRequest($request);
        $repo = $this->getDoctrine()->getRepository(ContenuDepot::class);
        $category = $repo->find($id);
        $depotsEtudiants->setContenuDepotId($category);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($depotsEtudiants);
            $entityManager->flush();
            $repo = $this->getDoctrine()->getRepository(DepotsEtudiants::class);
            $depotsEtudiants = $repo->findBy(array('contenu_depot_id' => $id));
            return $this->render('depots_etudiants/index.html.twig', ['depots_etudiants' => $depotsEtudiants, 'id' => $id]);
        }

        return $this->renderForm('depots_etudiants/new.html.twig', [
            'depot' => $depotsEtudiants,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="depots_etudiants_show", methods={"GET"})
     */
    public function show(DepotsEtudiants $depotsEtudiant): Response
    {
        return $this->render('depots_etudiants/show.html.twig', [
            'depots_etudiant' => $depotsEtudiant,
        ]);
    }

    /**
     * @Route("/{id}/edit/{id1}", name="depots_etudiants_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, DepotsEtudiants $depotsEtudiants, EntityManagerInterface $entityManager, $id1): Response
    {
        $form = $this->createForm(DepotsEtudiantsType::class, $depotsEtudiants);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $repo = $this->getDoctrine()->getRepository(DepotsEtudiants::class);
            $depotsEtudiants = $repo->findBy(array('contenu_depot_id' => $id1));
            return $this->render('depots_etudiants/index.html.twig', ['depots_etudiants' => $depotsEtudiants, 'id' => $id1]);
        }

        return $this->renderForm('depots_etudiants/edit.html.twig', [
            'depot' => $depotsEtudiants,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id1}/{id2}", name="depots_etudiants_delete")
     */
    public function delete_category($id1, $id2): Response
    {
        $repo = $this->getDoctrine()->getRepository(DepotsEtudiants::class);
        $depotsEtudiants = $repo->find($id2);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($depotsEtudiants);
        $manager->flush();
        $repo = $this->getDoctrine()->getRepository(DepotsEtudiants::class);
        $depos1 = $repo->findBy(array('contenu_depot_id' => $id1));
        return $this->render('depots_etudiants/index.html.twig', ['depots_etudiants' => $depos1, 'id' => $id1]);
    }
}
