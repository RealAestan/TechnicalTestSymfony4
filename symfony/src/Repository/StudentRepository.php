<?php
/**
 * This file is part of TechnicalTestSymfony4.
 *
 * @author  Anthony Margerand <anthony.margerand@protonmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link    https://github.com/RealAestan/TechnicalTestSymfony4
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
            ->leftJoin('s._marks', 'm')
            ->orderBy('s._id', 'DESC');

        return $this->_createPaginator($queryBuilder->getQuery(), $page);
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
            ->where('s._firstName LIKE :query')
            ->orWhere('s._lastName LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->setMaxResults(Student::SEARCH_MAX_ITEMS)
            ->orderBy('s._id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Query $query
     * @param int   $page
     *
     * @return Pagerfanta
     */
    private function _createPaginator(Query $query, int $page): Pagerfanta
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $paginator->setMaxPerPage(Student::PAGE_NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
    }
}
