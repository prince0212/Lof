<?php


namespace Lof\SalesRep\Block\Adminhtml\Salesrep;

use Magento\Framework\Data\Collection;

/**
 * Class Grid
 * @package Lof\SalesRep\Block\Adminhtml\Salesrep
 */
class Grid extends \Magento\Reports\Block\Adminhtml\Sales\Sales\Grid
{
    /**
     * @return Collection|null
     */
    public function getCreatedCollection()
    {
        return $this->getCollection();
    }

    /**
     * @return mixed
     */
    public function getResourceCollection()
    {
        return $this->getCreatedCollection()->getResourceCollection();
    }
}
