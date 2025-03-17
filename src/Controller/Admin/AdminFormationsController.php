<?php

namespace App\Controller\Admin;

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

class AdminFormationsController extends AbstractController
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

    #[Route('/admin/formations', name: 'admin_formations')]
    public function showAdminFormation(): Response{
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        return $this->render('admin/admin.formations.html.twig', [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }

    #[Route('/admin/formations/create', name: 'admin_formation_create')]
    public function createFormation(Request $request): Response{

        $formation = new Formation();

        $form = $this->createForm(FormationType::class, $formation, [
            'is_edit' => false
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($formation);
            $this->entityManager->flush();

            $this -> addFlash('success', 'Formation créée avec succès');
            return $this->redirectToRoute('admin_formations');
        }

        return $this->render('admin/_formation/form.formation.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/formations/{id}/edit', name: 'admin_formations_edit')]
    public function edit(Request $request, int $id): Response
    {
        $formation = $this->formationRepository->find($id);

        if (!$formation) {
            throw $this->createNotFoundException('Formation non trouvée.');
        }

        $form = $this->createForm(FormationType::class, $formation, [
            'is_edit' => true
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('admin_formations');
        }

        return $this->render('admin/_formation/form.formation.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/formations/{id}/delete', name: 'admin_formations_delete')]
    public function delete(int $id): Response
    {
        $formation = $this->formationRepository->find($id);

        if ($formation) {
            $this->entityManager->remove($formation);
            $this->entityManager->flush();
        } else {
            $this->addFlash('error', 'Formation non trouvée.');
        }

        return $this->redirectToRoute('admin_formations');
    }

    #[Route('/admin/formations/formation/{id}', name: 'admin_formations_showone')]
    public function showOne(int $id): Response{
        $formation = $this->formationRepository->find($id);
        return $this->render("admin/admin.formation.html.twig", [
            'formation' => $formation
        ]);
    }

    #[Route('/admin/formations/recherche/{champ}/{table}', name: 'admin_formations_findallcontain')]
    public function findAllContain(string $champ, Request $request, string $table=""): Response{
        $valeur = $request->get("recherche");
        $formations = $this->formationRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render('admin/admin.formations.html.twig', [
            'formations' => $formations,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table
        ]);
    }

    #[Route('/admin/formations/tri/{champ}/{ordre}/{table}', name: 'admin_formations_sort')]
    public function sort(string $champ, string $ordre, string $table=""): Response{
        $formations = $this->formationRepository->findAllOrderBy($champ, $ordre, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render('admin/admin.formations.html.twig', [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }

}
