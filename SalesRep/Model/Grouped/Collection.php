<?php
namespace Lof\SalesRep\Model\Grouped;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Lof\SalesRep\Model\Grouped
 */
class Collection extends \Magento\Reports\Model\Grouped\Collection
{
    /**
     * @return AbstractCollection|null
     */
    public function getResourceCollection(){
        return $this->_resourceCollection;
    }
}
