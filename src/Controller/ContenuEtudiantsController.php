<?php

namespace App\Controller;

use App\Entity\ContenuEtudiants;
use App\Entity\DepotsEtudiants;
use App\Form\ContenuEtudiantsType;
use App\Repository\ContenuEtudiantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/contenu/etudiants")
 */
class ContenuEtudiantsController extends AbstractController
{
    /**
     * @Route("/{id}", name="contenu_etudiants_index", methods={"GET"})
     */
    public function index(ContenuEtudiantsType $contenuDepotRepository,$id): Response
    {   $repo = $this->getDoctrine()->getRepository(ContenuEtudiants::class);
        $contenu_etudiants = $repo->findBy(array('depot_etudiant_id' => $id));
        return $this->render('contenu_etudiants/index.html.twig', ['contenu_etudiants' => $contenu_etudiants, 'id' => $id]);
    }

    /**
     * @Route("/new/{id}", name="contenu_etudiants_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,SluggerInterface $slugger,$id): Response
    {
        $DepotEtudiant = new ContenuEtudiants();
        $form = $this->createForm(ContenuEtudiantsType::class, $DepotEtudiant);
        $form->handleRequest($request);
        $repo = $this->getDoctrine()->getRepository(DepotsEtudiants::class);
        $depots = $repo->find($id);
        $DepotEtudiant->setDepotEtudiantId($depots);

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
                        $this->getParameter('brochures_directory2'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $DepotEtudiant->setBrochureFilename($newFilename);
            }
            $entityManager->persist($DepotEtudiant);
            $entityManager->flush();
            $repo = $this->getDoctrine()->getRepository(ContenuEtudiants::class);
            $DepotEtudiants = $repo->findBy(array('depot_etudiant_id' => $id));

            return $this->render('contenu_etudiants/index.html.twig', ['contenu_etudiants' => $DepotEtudiants, 'id' => $id]);
        }

        return $this->renderForm('contenu_etudiants/new.html.twig', [
            'contenu_etudiants' => $DepotEtudiant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="contenu_etudiants_show", methods={"GET"})
     */
    public function show(ContenuEtudiants $contenuEtudiant): Response
    {
        return $this->render('contenu_etudiants/show.html.twig', [
            'contenu_etudiants' => $contenuEtudiant,
        ]);
    }

    /**
     * @Route("/{id}/edit/{id1}", name="contenu_etudiants_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ContenuEtudiants $contenu_etudiant, EntityManagerInterface $entityManager,$id,$id1,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ContenuEtudiantsType::class, $contenu_etudiant);
        $form->handleRequest($request);

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
                        $this->getParameter('brochures_directory2'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $contenu_etudiant->setBrochureFilename($newFilename);
            }
            $entityManager->persist($contenu_etudiant);
            $entityManager->flush();
            $repo = $this->getDoctrine()->getRepository(ContenuEtudiants::class);
            $contenu_etudiants = $repo->findBy(array('depot_etudiant_id' => $id1));
            return $this->render('contenu_etudiants/index.html.twig', ['contenu_etudiants' => $contenu_etudiants, 'id' => $id]);
        }

        return $this->renderForm('contenu_etudiants/edit.html.twig', [
            'contenu_etudiants' => $contenu_etudiant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id1}/{id2}", name="contenu_etudiants_delete")
     */
    public function delete_category($id1, $id2): Response
    {
        $repo = $this->getDoctrine()->getRepository(ContenuEtudiants::class);
        $contenu_etudiant = $repo->find($id2);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($contenu_etudiant);
        $manager->flush();
        $repo = $this->getDoctrine()->getRepository(ContenuEtudiants::class);
        $contenu_etudiants = $repo->findBy(array('depot_etudiant_id' => $id1));
        return $this->render('contenu_etudiants/index.html.twig', ['contenu_etudiants' => $contenu_etudiants, 'id' => $id1]);
    }
}
