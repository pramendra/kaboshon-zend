<?php

namespace Catalog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;

/**
 * Repository for \Catalog\Entity\ProductPhoto
 */
class ProductPhoto extends EntityRepository
{
    public function findByProduct($product)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('pp')
            ->from('Catalog\Entity\Category', 'pp')
            ->where('pp.product <> :product')
            ->setParameter('product', $product)
            ->orderBy('p.id', 'ASC');
    }
}