<?php
namespace Lof\SalesRep\Model\ResourceModel\Order\Reports;


/**
 * Class Collection
 * @package Lof\SalesRep\Model\ResourceModel\Order\Reports
 */
class Collection extends \Magento\Reports\Model\ResourceModel\Order\Collection
{

    /**
     *
     */
    public function _renderFiltersBefore()
    {
        $this->getSelect()->where('main_table.salesrep_id = 2')->group('main_table.salesrep_id');
        return $this;
    }

}
