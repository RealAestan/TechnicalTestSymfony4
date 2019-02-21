<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Mark;
use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @author Anthony Margerand <anthony.margerand@protonmail.com>
 */
class MarkRepository extends ServiceEntityRepository
{
    /**
     * MarkRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mark::class);
    }

    /**
     * @param Student $student
     * @param int $page
     * @return Pagerfanta
     */
    public function findLatestOfStudent(Student $student, int $page = 1): Pagerfanta
    {
        $qb = $this->createQueryBuilder('m')
            ->addSelect('m')
            ->innerJoin('m.student', 's')
            ->andWhere('s = :student')
            ->setParameter('student', $student)
            ->orderBy('m.id', 'DESC');

        return $this->createPaginator($qb->getQuery(), $page);
    }

    /**
     * @param Query $query
     * @param int $page
     * @return Pagerfanta
     */
    private function createPaginator(Query $query, int $page): Pagerfanta
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $paginator->setMaxPerPage(Mark::PAGE_NUM_ITEMS);
        $paginator->setCurrentPage($page);
        return $paginator;
    }
}
