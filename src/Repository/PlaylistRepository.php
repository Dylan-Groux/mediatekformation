<?php

namespace App\Repository;

use App\Entity\Playlist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Playlist>
 */
class PlaylistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Playlist::class);
    }

    public function add(Playlist $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(Playlist $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * Retourne toutes les playlists triées sur le nom de la playlist
     * @param string $champ
     * @param string $ordre
     * @return Playlist[]
     */
    public function findAllOrderByName($ordre): array {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.formations', 'f')
            ->leftJoin('f.categories', 'c')
            ->addSelect('f', 'c') // Inclure les formations et les catégories liées à la playlist
            ->orderBy('p.name', $ordre) // Tri par nom de playlist
            ->getQuery()
            ->getResult(); // Retourne des objets Playlist complets avec leurs relations
    }

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
            $playlist->setNbFormations($result['nbFormations'] ?? 0); // Ajoute un setter dans ton entity Playlist
            $results[$index] = $playlist;
        }
    
        return $results;
    }

    /**
     * Enregistrements dont un champ contient une valeur
     * ou tous les enregistrements si la valeur est vide
     * @param type $champ
     * @param type $valeur
     * @param type $table si $champ dans une autre table
     * @return Playlist[]
     */
    public function findByContainValue($champ, $valeur, $table=""): array {
        if ($valeur == "") {
            return $this->findAllOrderByName('ASC');
        }
    
        if ($table == "") {
            return $this->createQueryBuilder('p')
                ->leftJoin('p.formations', 'f')
                ->groupBy('p.id')
                ->orderBy('p.name', 'ASC')
                ->getQuery()
                ->getResult();
        } else {
            return $this->createQueryBuilder('p')
                ->leftJoin('p.formations', 'f')
                ->leftJoin('f.categories', 'c')
                ->addSelect('f', 'c')
                ->where('c.' . $champ . ' LIKE :valeur')
                ->setParameter('valeur', '%' . $valeur . '%')
                ->groupBy('p.id, c.id')
                ->orderBy('p.name', 'ASC')
                ->getQuery()
                ->getResult();
        }
    }
}
