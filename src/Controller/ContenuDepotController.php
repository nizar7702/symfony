<?php

namespace App\Controller;

use App\Entity\ContenuDepot;
use App\Entity\Depots;
use App\Form\ContenuDepotType;
use App\Repository\ContenuDepotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/contenu/depot")
 */
class ContenuDepotController extends AbstractController
{
    /**
     * @Route("/{id}", name="contenu_depot_index", methods={"GET"})
     */
    public function index(ContenuDepotRepository $contenuDepotRepository,$id): Response
    {   $repo = $this->getDoctrine()->getRepository(ContenuDepot::class);
        $contenu_depots = $repo->findBy(array('depot_id' => $id));
        return $this->render('contenu_depot/index.html.twig', ['contenu_depots' => $contenu_depots, 'id' => $id]);
    }

    /**
     * @Route("/new/{id}", name="contenu_depot_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,SluggerInterface $slugger,$id): Response
    {
        $contenuDepot = new ContenuDepot();
        $form = $this->createForm(ContenuDepotType::class, $contenuDepot);
        $form->handleRequest($request);
        $repo = $this->getDoctrine()->getRepository(Depots::class);
        $depots = $repo->find($id);
        $contenuDepot->setDepotId($depots);

        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('brochure')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $contenuDepot->setBrochureFilename($newFilename);
            }
            $entityManager->persist($contenuDepot);
            $entityManager->flush();
            $repo = $this->getDoctrine()->getRepository(ContenuDepot::class);
            $contenu_depots = $repo->findBy(array('depot_id' => $id));

            return $this->render('contenu_depot/index.html.twig', ['contenu_depots' => $contenu_depots, 'id' => $id]);
        }

        return $this->renderForm('contenu_depot/new.html.twig', [
            'contenu_depot' => $contenuDepot,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="contenu_depot_show", methods={"GET"})
     */
    public function show(ContenuDepot $contenuDepot): Response
    {
        return $this->render('contenu_depot/show.html.twig', [
            'contenu_depot' => $contenuDepot,
        ]);
    }

    /**
     * @Route("/{id}/edit/{id1}", name="contenu_depot_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ContenuDepot $contenuDepot, EntityManagerInterface $entityManager,$id,$id1): Response
    {
        $form = $this->createForm(ContenuDepotType::class, $contenuDepot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $repo = $this->getDoctrine()->getRepository(ContenuDepot::class);
            $contenu_depots = $repo->findBy(array('depot_id' => $id1));
            return $this->render('contenu_depot/index.html.twig', ['contenu_depots' => $contenu_depots, 'id' => $id]);
        }

        return $this->renderForm('contenu_depot/edit.html.twig', [
            'contenu_depot' => $contenuDepot,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id1}/{id2}", name="contenu_depot_delete")
     */
    public function delete_category($id1, $id2): Response
    {
        $repo = $this->getDoctrine()->getRepository(ContenuDepot::class);
        $Contenudepot = $repo->find($id2);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($Contenudepot);
        $manager->flush();
        $repo = $this->getDoctrine()->getRepository(ContenuDepot::class);
        $depos1 = $repo->findBy(array('depot_id' => $id1));
        return $this->render('contenu_depot/index.html.twig', ['contenu_depots' => $depos1, 'id' => $id1]);
    }
}
