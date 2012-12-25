<?php

namespace Catalog\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Abstracts\CrudRepositoryInterface;

class Category extends EntityRepository implements CrudRepositoryInterface
{

    public function paginateWithParents($offset = 0, $limit = 0)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('c')
                ->from('Catalog\Entity\Category', 'c')
                ->join('c.parent', 'p')
                ->orderBy('c.id', 'ASC');

        if ($offset)
            $qb->setFirstResult($offset);

        if ($limit)
            $qb->setMaxResults($limit);

        $paginator = new Paginator($qb, true);

        return $paginator;
    }

    public function fetch($offset = 0, $limit = 0, $criteria = null)
    {
        return $this->paginateWithParents($offset, $limit);
    }

}
