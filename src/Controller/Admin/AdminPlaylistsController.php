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

class AdminPlaylistsController extends AbstractController
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

    #[Route('/admin/playlists', name: 'admin_playlists')]
    public function showAdminPlaylist(): Response{
        $playlists = $this->playlistRepository->findAllWithFormationCount();
        $categories = $this->categorieRepository->findAll();
        return $this->render('admin/admin.playlists.html.twig', [
            'playlists' => $playlists,
            'categories' => $categories
        ]);
    }

    #[Route('/admin/playlists/recherche/{champ}/{table}', name: 'admin_playlists.findallcontain')]
    public function findAllContain(string $champ, Request $request, string $table=""): Response{
        $valeur = $request->get("recherche");
        $playlists = $this->playlistRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render('admin/admin.playlists.html.twig', [
            'playlists' => $playlists,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table
        ]);
    }

    #[Route('/admin/playlists/tri/{champ}/{ordre}', name: 'admin_playlists.sort')]
    public function sort(string $champ, string $ordre): Response
    {
        if ($champ === "name") {
            $playlists = $this->playlistRepository->findAllOrderByName($ordre);
        } elseif ($champ === "nbFormations") {
            $playlists = $this->playlistRepository->findAllWithFormationCount($ordre);
        } else {
            $playlists = [];
        }
    
        $categories = $this->categorieRepository->findAll();
        return $this->render('admin/admin.playlists.html.twig', [
            'playlists' => $playlists,
            'categories' => $categories
        ]);
    }

    #[Route('/admin/playlist/create', name: 'admin_playlist_create')]
    public function createPlaylist(Request $request): Response
    {
        $playlist = new Playlist();
    
        $form = $this->createForm(PlaylistType::class, $playlist, [
            'is_edit' => false
        ]);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($playlist);
            $this->entityManager->flush();

            $this->addFlash('success', 'Playlist créée avec succès');
            return $this->redirectToRoute('admin_playlists');
        }
    
        return $this->render('admin/_playlist/form.playlist.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/playlists/{id}/edit', name: 'admin_playlists_edit')]
    public function edit(Request $request, int $id): Response
    {
        $playlist = $this->playlistRepository->find($id);

        if (!$playlist) {
            throw $this->createNotFoundException('Playlist non trouvée');
        }

        $form = $this->createForm(PlaylistType::class, $playlist, [
            'is_edit' => true
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('admin_playlists');
        }

        return $this->render('admin/_playlist/form.playlist.html.twig', [
            'playlist' => $playlist,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/playlists/{id}/delete', name: 'admin_playlists_delete')]
    public function delete(int $id): Response
    {
        $playlists = $this->playlistRepository->find($id);

        if (!$playlists) {
            $this->addFlash('error', 'Playlist non trouvée.');
        } elseif (count($playlists->getFormations()) > 0) {
            $this->addFlash('error', 'La playlist contient des formations.');
        }else {
            $this->addFlash('error', 'Playlist non trouvée.');
            $this->entityManager->remove($playlists);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('admin_playlists');
    }



}
