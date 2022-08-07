<?php

namespace App\Repository;

use App\Entity\Invitations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Invitations>
 *
 * @method Invitations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invitations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invitations[]    findAll()
 * @method Invitations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvitationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invitations::class);
    }

    public function add(Invitations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Invitations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getUserInvitations(int $user_id): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Invitations p
            WHERE p.receiver_id = :id
            ORDER BY p.id ASC'
        )->setParameter('id', $user_id);

        // returns an array of Product objects
        return $query->getResult();
    }

    public function getUnreadInvitations(int $user_id,int $acceptance): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Invitations p
            WHERE p.receiver_id = :id
            AND p.acceptance = :acceptance
            ORDER BY p.id ASC'
        )->setParameters(['id'=> $user_id, 'acceptance' => $acceptance]);

        // returns an array of Product objects
        return $query->getResult();
    }

   /**
    * @return Invitations[] Returns an array of Invitations objects
    */
   public function findByExampleField($value): array
   {
       return $this->createQueryBuilder('i')
           ->andWhere('i.exampleField = :val')
           ->setParameter('val', $value)
           ->orderBy('i.id', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

   public function findOneBySomeField($value): ?Invitations
   {
       return $this->createQueryBuilder('i')
           ->andWhere('i.exampleField = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }
}
