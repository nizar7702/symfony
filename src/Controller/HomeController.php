<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\RubriquesType;
use App\Entity\Rubriques;
use App\Repository\RubriquesRepository;
use Doctrine\DBAL\Types\ObjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Rubriques::class);
    $rubriques= $repo->findAll();

return $this->render('home/index.html.twig', ['rubrique' => $rubriques]);
}
     /**
     * @Route("admin/add_rubrique", name="add_rubrique")
     */
    public function add(Request $request): Response
    {
        $task = new Rubriques();
     

        $form = $this->createForm(RubriquesType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($task);
             $entityManager->flush();
        
            return $this->redirectToRoute('home');
        }

        return $this->renderForm('rubriques\add.html.twig', [
            'formpro' => $form,
        ]);
    }
    /**
     * @Route("/admin/delete_rubrique/{id}", name="delete_rubrique")
     */
    public function delete_rubrique($id): Response
    {   $repo = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repo->findBy(array('rubrique_id' => $id));
        $manager1 = $this->getDoctrine()->getManager();
        foreach ($categories as $categories) {
            $manager1->remove($categories);
        }
        $manager1->flush();
        $repo = $this->getDoctrine()->getRepository(Rubriques::class);
        $Rubriques= $repo->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($Rubriques);
        $manager->flush();
        return $this->redirectToRoute('home');
    }
    /**
 * @Route("/admin/update_rubrique/{id}", name="update_rubrique")
 */
public function update_rubrique(Request $request, int $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();

    $rubrique = $entityManager->getRepository(Rubriques::class)->find($id);
    $form = $this->createForm(RubriquesType::class, $rubrique);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())
    {
        $entityManager->flush();
        return $this->redirectToRoute('home');
    }

    return $this->render('rubriques\add.html.twig', [
        "form_title" => "Modifier un produit",
        "formpro" => $form->createView(),
    ]);
}
    }

