<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Formation;
use App\Entity\Playlist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FormationRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlaylistRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\FormationType;
use App\Form\PlaylistType;
use App\Form\CategorieType;

class AdminCategoriesController extends AbstractController
{

    private FormationRepository $formationRepository;
    private CategorieRepository $categorieRepository;
    private EntityManagerInterface $entityManager;
    private PlaylistRepository $playlistRepository;
    
    public function __construct(EntityManagerInterface $entityManager, FormationRepository $formationRepository, CategorieRepository $categorieRepository, PlaylistRepository $playlistRepository) {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository= $categorieRepository;
        $this->entityManager = $entityManager;
        $this->playlistRepository = $playlistRepository;
    }

    #[Route('/admin/categories', name: 'admin_categories')]
    public function showCategories(Request $request, CategorieRepository $categorieRepository): Response{
        $categories = $this->categorieRepository->findAll();

        // Créer le formulaire pour une nouvelle catégorie
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie, [
            'is_edit' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $existingCategorie = $categorieRepository->findOneBy(['name' => $categorie->getName()]);
            
            if($existingCategorie){
                $this->addFlash('error', 'Cette catégorie existe déjà.');
                return $this->redirectToRoute('admin_categories');
            } else {
                $this->entityManager->persist($categorie);
                $this->entityManager->flush();

                $this -> addFlash('success', 'Catégorie créée avec succès');
                return $this->redirectToRoute('admin_categories');
            }
        }

        return $this->render('admin/admin.categories.html.twig', [
            'categories' => $categories,
            'form' => $form->createView(), // Passer le formulaire à la vue
        ]);
    }

    #[Route('/admin/categories/{id}/delete', name: 'admin_categories_delete')]
    public function delete(int $id): Response
    {
        $categorie = $this->categorieRepository->find($id);

        if (!$categorie) {
            $this->addFlash('error', 'Catégorie non trouvée.');
        } elseif (count($categorie->getFormations()) > 0) {
            $this->addFlash('error', 'La catégorie contient des formations.');
        }else {
            $this->entityManager->remove($categorie);
            $this->entityManager->flush();
            $this->addFlash('success', 'Catégorie supprimer avec succès.');
        }

        return $this->redirectToRoute('admin_categories');
    }

    #[Route('/admin/categorie/create', name: 'admin_categorie_create')]
    public function createFormation(Request $request, CategorieRepository $categorieRepository):Response{
        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie, [
            'is_edit' => false
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $existingCategorie = $categorieRepository->findOneBy(['name' => $categorie->getName()]);

            if($existingCategorie){
                $this->addFlash('error', 'Cette catégorie existe déjà.');
                return $this->redirectToRoute('admin_categories');
            } else {
                $this->entityManager->persist($categorie);
                $this->entityManager->flush();

                $this -> addFlash('success', 'Catégorie créée avec succès');
                return $this->redirectToRoute('admin_categories');
            }
        }

        return $this->render('admin/_categorie/form.categorie.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}