<?php

namespace Catalog\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Abstracts\CrudRepositoryInterface;

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

    public function fetch($offset = 0, $limit = 0)
    {
        return $this->getAdminPaginator($offset, $limit);
    }

    public function findWithoutId($id)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('c')
            ->from('Catalog\Entity\Category', 'c')
            ->where('c.id <> :id')
            ->setParameter('id', $id)
            ->orderBy('c.id', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
