<?php
namespace Lof\SalesRep\Model\ResourceModel\Order;

/**
 * Class Creditmemo
 * @package Lof\SalesRep\Model\ResourceModel\Order
 */
class Creditmemo extends \Magento\Sales\Model\ResourceModel\Order\Creditmemo
{
    /**
     * Perform actions before object save
     *
     * @param \Magento\Framework\Model\AbstractModel|\Magento\Framework\DataObject $object
     * @return \Magento\Sales\Model\ResourceModel\Order\Invoice
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        /** @var \Magento\Sales\Model\Order\Invoice $object */
        if ($object->getOrder()) {
            $object->setAssignSalesrepId($object->getOrder()->getAssignSalesrepId());
            $object->setSalesrepId($object->getOrder()->getSalesrepId());
        }
        return parent::_beforeSave($object);
    }

}
