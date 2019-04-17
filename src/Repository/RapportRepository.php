<?php

namespace App\Repository;

use App\Entity\Rapport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Rapport|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rapport|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rapport[]    findAll()
 * @method Rapport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapportRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Rapport::class);
    }
}