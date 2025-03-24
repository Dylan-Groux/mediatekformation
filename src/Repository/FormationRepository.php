<?php

namespace App\Repository;

use App\Entity\Formation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Référentiel pour la gestion des entités Formation.
 * 
 * Ce référentiel fournit des méthodes pour interagir avec l'entité Formation,
 * y compris des requêtes personnalisées pour trier, rechercher et filtrer les formations.
 * 
 * @extends ServiceEntityRepository<Formation>
 */
class FormationRepository extends ServiceEntityRepository
{
    /**
     * Constructeur du FormationRepository.
     *
     * @param ManagerRegistry $registry Le registre des gestionnaires pour Doctrine.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formation::class);
    }

    /**
     * Ajoute une formation dans la base de données.
     *
     * @param Formation $entity La formation à ajouter.
     */
    public function add(Formation $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * Supprime une formation de la base de données.
     *
     * @param Formation $entity La formation à supprimer.
     */
    public function remove(Formation $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * Retourne toutes les formations triées sur un champ.
     *
     * @param string $champ Le champ sur lequel trier.
     * @param string $ordre L'ordre de tri (ASC ou DESC).
     * @param string $table La table associée si le champ est dans une autre table.
     *
     * @return Formation[] Retourne un tableau d'objets Formation triés.
     */
    public function findAllOrderBy(string $champ, string $ordre, string $table = ""): array
    {
        if ($table == "") {
            return $this->createQueryBuilder('f')
                ->orderBy('f.' . $champ, $ordre)
                ->getQuery()
                ->getResult();
        } else {
            return $this->createQueryBuilder('f')
                ->join('f.' . $table, 't')
                ->orderBy('t.' . $champ, $ordre)
                ->getQuery()
                ->getResult();
        }
    }

    /**
     * Recherche des formations dont un champ contient une valeur.
     *
     * Si la valeur est vide, retourne toutes les formations.
     *
     * @param string $champ Le champ à rechercher.
     * @param string $valeur La valeur à rechercher.
     * @param string $table La table associée si le champ est dans une autre table.
     *
     * @return Formation[] Retourne un tableau d'objets Formation correspondant aux critères.
     */
    public function findByContainValue(string $champ, string $valeur, string $table = ""): array
    {
        if ($valeur == "") {
            return $this->findAll();
        }
        if ($table == "") {
            return $this->createQueryBuilder('f')
                ->where('f.' . $champ . ' LIKE :valeur')
                ->orderBy('f.publishedAt', 'DESC')
                ->setParameter('valeur', '%' . $valeur . '%')
                ->getQuery()
                ->getResult();
        } else {
            return $this->createQueryBuilder('f')
                ->join('f.' . $table, 't')
                ->where('t.' . $champ . ' LIKE :valeur')
                ->orderBy('f.publishedAt', 'DESC')
                ->setParameter('valeur', '%' . $valeur . '%')
                ->getQuery()
                ->getResult();
        }
    }

    /**
     * Retourne les n formations les plus récentes.
     *
     * @param int $nb Le nombre de formations à retourner.
     *
     * @return Formation[] Retourne un tableau des n formations les plus récentes.
     */
    public function findAllLasted(int $nb): array
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.publishedAt', 'DESC')
            ->setMaxResults($nb)
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne la liste des formations d'une playlist.
     *
     * @param int $idPlaylist L'identifiant de la playlist.
     *
     * @return Formation[] Retourne un tableau d'objets Formation associés à la playlist.
     */
    public function findAllForOnePlaylist(int $idPlaylist): array
    {
        return $this->createQueryBuilder('f')
            ->leftJoin('f.playlist', 'p')
            ->where('p.id = :id')
            ->setParameter('id', $idPlaylist)
            ->orderBy('f.publishedAt', 'ASC')
            ->getQuery()
            ->getResult();
    }
}