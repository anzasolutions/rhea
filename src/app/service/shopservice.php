<?php

namespace app\service;

use core\db\exception\NoResultException;
use core\service\AbstractService;
use core\service\ServiceException;

class ShopService extends AbstractService
{
    public function getCategoryProducts($category, $limit = 5)
    {
        try
        {
            return $this->dao->product->findByCategoryId($category, $limit);
        }
        catch (NoResultException $e)
        {
            throw new ServiceException();
        }
    }
}

?>