<?php

namespace App\Repository;

use App\Entity\Avisetcommentaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Avisetcommentaires>
 *
 * @method Avisetcommentaires|null find($id, $lockMode = null, $lockVersion = null)
 * @method Avisetcommentaires|null findOneBy(array $criteria, array $orderBy = null)
 * @method Avisetcommentaires[]    findAll()
 * @method Avisetcommentaires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avisetcommentaires::class);
    }

//    /**
//     * @return Avisetcommentaires[] Returns an array of Avisetcommentaires objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Avisetcommentaires
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
