<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_SalesRep
 * @copyright  Copyright (c) 2021 Landofcoder (https://www.landofcoder.com/)
 * @license    https://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\SalesRep\Observer\Order;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class SalesOrderSaveSalesRep
 * @package Lof\SalesRep\Observer\Order
 */
class SalesOrderSaveSalesRep implements ObserverInterface
{
    /**
     * SalesRep resource model
     *
     * @var \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer
     */
    protected $_salesrepCustomerFactory;

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Collection
     */
    protected $_collection;

    /**
     * @param \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer $salesrepCustomerResource
     * @param \Magento\Sales\Model\ResourceModel\Order\Collection $collection
     */
    public function __construct(
        \Lof\SalesRep\Model\SalesrepCustomerFactory $_salesrepCustomerFactory,
        \Magento\Sales\Model\ResourceModel\Order\Collection $collection
    ) {
        $this->_salesrepCustomerFactory     = $_salesrepCustomerFactory;
        $this->_collection                  = $collection;
    }

    /**
     * Save current admin password to prevent its usage when changed in the future.
     *
     * @param EventObserver $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {
        $orderIds = $observer->getEvent()->getOrderIds();
        if (!$orderIds || !is_array($orderIds)) {
            return $this;
        }
        $order = $this->_collection->addFieldToFilter('entity_id', ['in' => $orderIds])->getFirstItem();
        $customerId  = $order->getCustomerId();
        if( $customerId ) {
            $userId = $this->getCurrentSalerep($customerId);
            if(isset($userId) && $userId !== null){
                $order->setSalesrepId($userId);
                $order->setAssignSalesrepId($userId);
            }else{
                $order->setSalesrepId(0);
                $order->setAssignSalesrepId(0);
            }
            $order->save();
        }
    }

    /**
     * @param $customerId
     * @return |null
     */
    protected function getCurrentSalerep($customerId){
        $users = $this->_salesrepCustomerFactory->create()->getCollection()->addFieldToFilter('customer_id', array('eq' => $customerId))->load();
        if($users && count($users) > 0){
            return $users->getFirstItem()->getUserId();
        }
        return null;
    }
}










