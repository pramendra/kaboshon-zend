<?php

namespace Abstracts;

interface CrudRepositoryInterface
{
    public function fetch($offset = 0, $limit = 0, $criteria = null);
}