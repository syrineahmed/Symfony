<?php 
namespace App\Repository;

use App\Entity\Userhotel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Userhotel>
 */
class UserHotelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Userhotel::class);
    }

    public function save(Userhotel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Userhotel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // Vous pouvez ajouter des méthodes spécifiques au besoin de votre application.
    public function countUsersByObject(): array
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u.pays, COUNT(u.numpassport) as countPays')
            ->groupBy('u.pays')
            ->getQuery();

        return $qb->getResult();
    }
}
