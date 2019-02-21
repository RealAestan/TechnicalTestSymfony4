<?php
/*
 * This file is part of TechnicalTestSymfony4.
 *
 * @author Anthony Margerand <anthony.margerand@protonmail.com>
 * @link https://github.com/RealAestan/TechnicalTestSymfony4
 */
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @author Anthony Margerand <anthony.margerand@protonmail.com>
 */
class StudentRepository extends ServiceEntityRepository
{
    /**
     * StudentRepository constructor.
     *
     * @param ManagerRegistry $registry registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    /**
     * @param int $page page
     *
     * @return Pagerfanta
     */
    public function findLatest(int $page = 1): Pagerfanta
    {
        $queryBuilder = $this->createQueryBuilder('s')
            ->addSelect('s', 'm')
            ->leftJoin('s.marks', 'm')
            ->orderBy('s.id', 'DESC');

        return $this->createPaginator($queryBuilder->getQuery(), $page);
    }

    /**
     * @param string $query query
     *
     * @return Student[]
     */
    public function search(string $query): array
    {
        // TODO Replace search with elasticsearch
        return $this->createQueryBuilder('s')
            ->addSelect('s')
            ->where('s.firstName LIKE :query')
            ->orWhere('s.lastName LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->setMaxResults(Student::SEARCH_MAX_ITEMS)
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Query $query
     * @param int   $page
     *
     * @return Pagerfanta
     */
    private function createPaginator(Query $query, int $page): Pagerfanta
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $paginator->setMaxPerPage(Student::PAGE_NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
    }
}
