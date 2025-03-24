<?php

namespace App\Repository;

use App\Entity\Playlist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Référentiel pour la gestion des entités Playlist.
 * 
 * Ce référentiel fournit des méthodes pour interagir avec l'entité Playlist,
 * y compris des requêtes personnalisées pour récupérer les playlists avec des formations associées.
 * 
 * @extends ServiceEntityRepository<Playlist>
 */
class PlaylistRepository extends ServiceEntityRepository
{
    /**
     * Constructeur du PlaylistRepository.
     *
     * @param ManagerRegistry $registry Le registre des gestionnaires pour Doctrine.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Playlist::class);
    }

    /**
     * Ajoute une playlist dans la base de données.
     *
     * @param Playlist $entity La playlist à ajouter.
     */
    public function add(Playlist $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * Supprime une playlist de la base de données.
     *
     * @param Playlist $entity La playlist à supprimer.
     */
    public function remove(Playlist $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * Retourne toutes les playlists triées par le nom.
     *
     * @param string $ordre L'ordre de tri (ASC ou DESC).
     *
     * @return Playlist[] Retourne un tableau d'objets Playlist.
     *
     * @throws \InvalidArgumentException Si l'ordre de tri est invalide.
     */
    public function findAllOrderByName(string $ordre): array
    {
        if (!in_array($ordre, ['ASC', 'DESC'])) {
            throw new \InvalidArgumentException('Ordre de tri invalide');
        }

        $qb = $this->createQueryBuilder('p')
            ->select('p, COUNT(f.id) AS nbFormations')
            ->leftJoin('p.formations', 'f')
            ->leftJoin('f.categories', 'c')
            ->addSelect('f', 'c') // Inclure les formations et les catégories liées à la playlist
            ->groupBy('p.id')
            ->orderBy('p.name', $ordre)
            ->getQuery();

        $results = $qb->getResult();

        // Associer le nombre de formations aux objets Playlist
        foreach ($results as $index => $result) {
            $playlist = $result[0]; // L'objet Playlist
            $playlist->setNbFormations($result['nbFormations'] ?? 0);
            $results[$index] = $playlist;
        }

        return $results;
    }

    /**
     * Retourne toutes les playlists avec le nombre de formations associées.
     *
     * @param string $ordre L'ordre de tri (ASC ou DESC).
     *
     * @return Playlist[] Retourne un tableau d'objets Playlist avec le nombre de formations.
     */
    public function findAllWithFormationCount(string $ordre = "ASC"): array
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p, COUNT(f.id) AS nbFormations')
            ->leftJoin('p.formations', 'f')
            ->groupBy('p.id')
            ->orderBy('nbFormations', $ordre)
            ->getQuery();

        $results = $qb->getResult();

        // Associer le nombre de formations aux objets Playlist
        foreach ($results as $index => $result) {
            $playlist = $result[0]; // L'objet Playlist
            $playlist->setNbFormations($result['nbFormations'] ?? 0);
            $results[$index] = $playlist;
        }

        return $results;
    }

    /**
     * Recherche des playlists dont un champ contient une valeur donnée.
     *
     * @param string $champ Le champ à rechercher.
     * @param string $valeur La valeur à rechercher.
     * @param string $table La table associée si le champ est dans une autre table.
     *
     * @return Playlist[] Retourne un tableau d'objets Playlist correspondant aux critères.
     */
    public function findByContainValue(string $champ, string $valeur, string $table = ""): array
    {
        if ($valeur === "") {
            return $this->findAllOrderByName('ASC');
        }

        if ($table === "") {
            $qb = $this->createQueryBuilder('p')
                ->select('p, COUNT(f.id) AS nbFormations')
                ->leftJoin('p.formations', 'f')
                ->where('p.' . $champ . ' LIKE :valeur')
                ->setParameter('valeur', '%' . $valeur . '%')
                ->groupBy('p.id')
                ->orderBy('p.name', 'ASC')
                ->getQuery();

            $results = $qb->getResult();

            // Associer le nombre de formations aux objets Playlist
            foreach ($results as $index => $result) {
                $playlist = $result[0];
                $playlist->setNbFormations($result['nbFormations'] ?? 0);
                $results[$index] = $playlist;
            }
        } else {
            $qb = $this->createQueryBuilder('p')
                ->select('p, COUNT(f.id) AS nbFormations')
                ->leftJoin('p.formations', 'f')
                ->leftJoin('f.categories', 'c')
                ->addSelect('f', 'c')
                ->where('c.' . $champ . ' LIKE :valeur')
                ->setParameter('valeur', '%' . $valeur . '%')
                ->groupBy('p.id, c.id')
                ->orderBy('p.name', 'ASC')
                ->getQuery();

            $results = $qb->getResult();

            // Associer le nombre de formations aux objets Playlist
            foreach ($results as $index => $result) {
                $playlist = $result[0];
                $playlist->setNbFormations($result['nbFormations'] ?? 0);
                $results[$index] = $playlist;
            }
        }

        return $results;
    }
}