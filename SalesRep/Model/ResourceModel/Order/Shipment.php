<?php
namespace Lof\SalesRep\Model\ResourceModel\Order;

/**
 * Class Shipment
 * @package Lof\SalesRep\Model\ResourceModel\Order
 */
class Shipment extends \Magento\Sales\Model\ResourceModel\Order\Shipment
{
    /**
     * Perform actions before object save
     *
     * @param \Magento\Framework\Model\AbstractModel|\Magento\Framework\DataObject $object
     * @return \Magento\Sales\Model\ResourceModel\Order\Shipment
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        /** @var \Magento\Sales\Model\Order\Shipment $object */
        if ($object->getOrder()) {
            $object->setAssignSalesrepId($object->getOrder()->getAssignSalesrepId());
            $object->setSalesrepId($object->getOrder()->getSalesrepId());
        }
        return parent::_beforeSave($object);
    }

}
