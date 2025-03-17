<?php

namespace App\Controller;

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

}
