<?php

namespace Catalog\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Repository for Product entity
 */
class ProductRepository extends EntityRepository
{
    protected $qb;

    public function getQueryBuilder()
    {
        if ($this->qb)
            return $this->qb;
        $this->qb = $this->_em->createQueryBuilder();
        return $this->qb;
    }

    /**
     * Fetch entities from admin panel
     * @param int $offset
     * @param int $limit
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getAdminPaginator($offset = 0, $limit = 20)
    {
        $qb = $this->getQueryBuilder();
        $qb->select('p')
            ->from('Catalog\Entity\Product', 'p')
            ->innerJoin('p.category', 'c')
            ->orderBy('p.id', 'DESC');

        if ($offset)
            $qb->setFirstResult($offset);

        if ($limit)
            $qb->setMaxResults($limit);

        $paginator = new Paginator($qb);

        return $paginator;
    }
}
