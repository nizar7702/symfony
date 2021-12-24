<?php

namespace App\Controller;

use App\Entity\ContenuDepot;
use App\Entity\Depots;
use App\Entity\Likes;
use App\Form\ContenuDepotType;
use App\Repository\ContenuDepotRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Twig\Node\Expression\Test\NullTest;

/**
 * @Route("/contenu/depot")
 */
class ContenuDepotController extends AbstractController
{
    /**
     * @Route("/{id}", name="contenu_depot_index", methods={"GET"})
     */
    public function index(ContenuDepotRepository $contenuDepotRepository, $id): Response
    {
        $repo = $this->getDoctrine()->getRepository(ContenuDepot::class);
        $contenu_depots = $repo->findBy(array('depot_id' => $id));
        $repo1 = $this->getDoctrine()->getRepository(Likes::class);
        $like = $repo1->findBy(array('contenu_depot_id' => $id));
        if (is_null($like)) {
            $likes = 0;
        } else {
            $likes = count($like);
        }
        return $this->render('contenu_depot/index.html.twig', ['contenu_depots' => $contenu_depots, 'id' => $id, 'likes' => $likes]);
    }

    /**
     * @Route("/new/{id}", name="contenu_depot_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, $id): Response
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
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

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

            $repo1 = $this->getDoctrine()->getRepository(Likes::class);
            $like = $repo1->findBy(array('contenu_depot_id' => $id));
            if (is_null($like)) {
                $likes = 0;
            } else {
                $likes = count($like);
            }
            return $this->render('contenu_depot/index.html.twig', ['contenu_depots' => $contenu_depots, 'id' => $id, 'likes' => $likes]);
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
        $filename = $contenuDepot->getBrochureFilename();
        return $this->render('contenu_depot/show.html.twig', [
            'contenu_depot' => $contenuDepot, 'filename' => $filename
        ]);
    }

    /**
     * @Route("/{id}/edit/{id1}", name="contenu_depot_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ContenuDepot $contenuDepot, EntityManagerInterface $entityManager, $id, $id1, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ContenuDepotType::class, $contenuDepot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('brochure')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

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
            $entityManager->flush();
            $repo = $this->getDoctrine()->getRepository(ContenuDepot::class);
            $contenu_depots = $repo->findBy(array('depot_id' => $id1));

            $repo1 = $this->getDoctrine()->getRepository(Likes::class);
            $like = $repo1->findBy(array('contenu_depot_id' => $id));
            $likes = count($like);
            if (is_null($like)) {
                $likes = 0;
            } else {
                $likes = count($like);
            }
            return $this->render('contenu_depot/index.html.twig', ['contenu_depots' => $contenu_depots, 'id' => $id, 'likes' => $likes]);
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
        $repo1 = $this->getDoctrine()->getRepository(Likes::class);
        $like = $repo1->findBy(array('contenu_depot_id' => $id1));
        if(is_null($like)){$likes= 0 ;}
        else{
        $likes=count($like);}
        return $this->render('contenu_depot/index.html.twig', ['contenu_depots' => $depos1, 'id' => $id1, 'likes' => $likes]);
    }
    /**
     * @Route("/like/{id}", name="contenu_depot_like", methods={"GET", "POST"})
     */
    public function like($id): Response
    {   
        $manager = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $repo = $this->getDoctrine()->getRepository(Depots::class);
        $depots = $repo->find($id);
        $search = (array) $this->getDoctrine()->getRepository(Likes::class)->findBy(array('contenu_depot_id' => $id,'user_id'=>$user));
        if($search ==[]){
        $like = new Likes();
        $like->setUserId($user)
            ->setContenuDepotId($depots);
        $manager->persist($like);
        $manager->flush();}
        $repo1 = $this->getDoctrine()->getRepository(Likes::class)->findBy(array('contenu_depot_id' => $id));
        $likes2=count($repo1);
        $repoo = $this->getDoctrine()->getRepository(Depots::class);
        $depoot = $repoo->find($id);
        $depoot->setNbLikes($likes2);
        $manager->persist($depoot);
        $manager->flush();
        $repo = $this->getDoctrine()->getRepository(ContenuDepot::class);
        $depos1 = $repo->findBy(array('depot_id' => $id));
        return $this->render('contenu_depot/index.html.twig', ['contenu_depots' => $depos1, 'id' => $id, 'likes' => $likes2]);
    }
}
