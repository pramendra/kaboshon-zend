<?php

namespace Catalog\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;


/**
 * Repository for \Catalog\Entity\Category
 */
class Category extends EntityRepository
{
    public function getAdminPaginator($offset = 0, $limit = 0)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('c')
            ->from('Catalog\Entity\Category', 'c')
            ->leftJoin('c.parent', 'p')
            ->orderBy('c.id', 'ASC');

        if ($offset)
            $qb->setFirstResult($offset);

        if ($limit)
            $qb->setMaxResults($limit);

        $paginator = new Paginator($qb);

        return $paginator;
    }

    /**
     * Find categories exclude specified category
     * @param $category
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function findWithoutId($category)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('c')
            ->from('Catalog\Entity\Category', 'c')
            ->where('c <> :category')
            ->setParameter('category', $category)
            ->orderBy('c.id', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
