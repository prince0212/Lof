<?php
namespace Lof\SalesRep\Model\ResourceModel\Report\Order\Updated;


/**
 * Class Collection
 * @package Lof\SalesRep\Model\ResourceModel\Report\Order\Updated
 */
class Collection extends \Lof\SalesRep\Model\ResourceModel\Report\Order\Collection
{
    /**
     * Aggregated Data Table
     *
     * @var string
     */
    protected $_aggregationTable = 'sales_order_aggregated_updated';
}
