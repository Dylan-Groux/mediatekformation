<?php
namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\FormationType;

/**
 * Controleur des formations
 *
 * @author emds
 */
class FormationsController extends AbstractController {

    private FormationRepository $formationRepository;
    private CategorieRepository $categorieRepository;
    private EntityManagerInterface $entityManager;

    private const TEMPLATE_PATH = "pages/formations.html.twig";
    
    public function __construct(EntityManagerInterface $entityManager, FormationRepository $formationRepository, CategorieRepository $categorieRepository) {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository= $categorieRepository;
        $this->entityManager = $entityManager;
    }
    
    #[Route('/formations', name: 'formations')]
    public function index(): Response{
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::TEMPLATE_PATH, [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }

    #[Route('/formations/tri/{champ}/{ordre}/{table}', name: 'formations.sort')]
    public function sort(string $champ, string $ordre, string $table=""): Response{
        $formations = $this->formationRepository->findAllOrderBy($champ, $ordre, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::TEMPLATE_PATH, [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }

    #[Route('/formations/recherche/{champ}/{table}', name: 'formations.findallcontain')]
    public function findAllContain(string $champ, Request $request, string $table=""): Response{
        $valeur = $request->get("recherche");
        $formations = $this->formationRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::TEMPLATE_PATH, [
            'formations' => $formations,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table
        ]);
    }

    #[Route('/formations/formation/{id}', name: 'formations.showone')]
    public function showOne(int $id): Response{
        $formation = $this->formationRepository->find($id);
        return $this->render("pages/formation.html.twig", [
            'formation' => $formation
        ]);
    }

    #[Route('/formations/{id}/delete', name: 'formations_delete')]
    public function delete(int $id): Response
    {
        $formation = $this->formationRepository->find($id);

        if ($formation) {
            $this->entityManager->remove($formation);
            $this->entityManager->flush();
        } else {
            $this->addFlash('error', 'Formation non trouvée.');
        }

        return $this->redirectToRoute('formations');
    }
    
    #[Route('/formations/{id}/edit', name: 'formations_edit')]
    public function edit(Request $request, int $id): Response
    {
        $formation = $this->formationRepository->find($id);

        if (!$formation) {
            throw $this->createNotFoundException('Formation non trouvée.');
        }

        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('formations');
        }

        return $this->render('pages/formations/edit.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }
}
