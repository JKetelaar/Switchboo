<?php

namespace App\Repository;

use App\Entity\PersonalInformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PersonalInformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonalInformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonalInformation[]    findAll()
 * @method PersonalInformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonalInformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonalInformation::class);
    }

    // /**
    //  * @return PersonalInformation[] Returns an array of PersonalInformation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PersonalInformation
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
