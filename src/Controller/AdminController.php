<?php

namespace App\Controller;

use App\Entity\Playlist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FormationRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlaylistRepository;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
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


    #[Route('/admin', name: 'admin_accueil')]
    public function index(): Response
    {
        $formations = $this->formationRepository->findAllLasted(3);
        return $this->render('admin.html.twig',[
            'formations' => $formations
        ]);
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

}
