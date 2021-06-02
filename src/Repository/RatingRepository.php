<?php

namespace App\Repository;

use App\Entity\Rating;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rating|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rating|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rating[]    findAll()
 * @method Rating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rating::class);
    }

    public function getUserRatings()
    {
        $qb = $this->createQueryBuilder('r')
            ->select(User::class)
            ->andWhere('r.id = 2')
            ->getQuery()
            ->execute();

        dd($qb, 123);

        $qbRatings =  $this->createQueryBuilder('r')
//            ->select('id', 'rate')
            ->join(Rating::class, 'res', 'res.recipient = 1');
//        dd($qbRatings->getQuery()->execute());
        return $qbRatings;
    }

    public function checkIfUserGaveRating($id, $auth_user_id)
    {
        $qb = $this->createQueryBuilder('r')
//            ->select(Rating::class)
            ->andWhere("r.recipient = $id")
            ->getQuery()
            ->execute();

        $userGaveARate = false;

        array_map(function ($value) use ($auth_user_id, &$userGaveARate) {
//            dump($value->getUserGiverId()->getId(), $auth_user_id);
            if ($auth_user_id == $value->getUserGiverId()->getId()) {
                $userGaveARate = true;
            }
        }, $qb);

        return $userGaveARate;

//        dd($qb[0]->getUserGiverId()->getId(), 123);
    }

    // /**
    //  * @return Rating[] Returns an array of Rating objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rating
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
