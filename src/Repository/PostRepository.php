<?php

namespace App\Repository;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function getPosts($active_users)
    {
        // row sql
        //  select * from post where user_id_id in (select id from user where is_active = true);

        $qb = $this->createQueryBuilder('p')
            ->andWhere('p.is_active = :active')
            ->orderBy('p.id', 'DESC')
            ->join('p.user_id', 'u')
            ->andWhere('u.is_active = :active')
            ->setParameter(':active', 1);

//dd($qb->getQuery()->execute());
//        $qb_post = $this->createQueryBuilder('p')
//            ->andwhere('p.is_active = :active')
//            ->setParameter(':active', 1)
//            ->getQuery()->execute();
//
//
////        $qb_post->getQuery()->execute();
//        dd($qb_post);

        return $qb->getQuery()->execute();
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
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
    }s
    */

    /*
    public function findOneBySomeField($value): ?Post
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
