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
     *
     * @param ManagerRegistry $registry registre
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mark::class);
    }

    /**
     * @param Student $student student
     * @param int     $page    page
     *
     * @return Pagerfanta
     */
    public function findLatestOfStudent(Student $student, int $page = 1): Pagerfanta
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->addSelect('m')
            ->innerJoin('m._student', 's')
            ->andWhere('s = :student')
            ->setParameter('student', $student)
            ->orderBy('m._id', 'DESC');

        return $this->_createPaginator($queryBuilder->getQuery(), $page);
    }

    /**
     * @param Query $query query
     * @param int   $page  page
     *
     * @return Pagerfanta
     */
    private function _createPaginator(Query $query, int $page): Pagerfanta
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $paginator->setMaxPerPage(Mark::PAGE_NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
    }
}
