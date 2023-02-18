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

namespace Lof\SalesRep\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class CustomerSalesRepSaveAfter
 * @package Lof\SalesRep\Observer
 */
class CustomerSalesRepSaveAfter implements ObserverInterface
{
    /**
     * SalesRep resource model
     *
     * @var \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer
     */

    protected $salesrepCustomerResource;
    /**
     * @var \Lof\SalesRep\Model\SalesrepCustomerFactory
     */
    protected $_salesrepCustomerFactory;
    /**
     * @param \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer $salesrepCustomerResource
     * @param \Lof\SalesRep\Model\SalesrepCustomerFactory $_salesrepCustomerFactory
     */
    public function __construct(
        \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer $salesrepCustomerResource,
        \Lof\SalesRep\Model\SalesrepCustomerFactory $_salesrepCustomerFactory
    ) {
        $this->salesrepCustomerResource         = $salesrepCustomerResource;
        $this->_salesrepCustomerFactory         = $_salesrepCustomerFactory;
    }

    /**
     * Save current admin password to prevent its usage when changed in the future.
     *
     * @param EventObserver $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {
        $customer   = $observer->getData('request')->getPostValue();
        $customerId = $observer->getData('customer')->getId();
        $userId = isset($customer['user_id'])?(int)$customer['user_id']:0;
        $this->salesrepCustomerResource->_deleteCustomer($customerId);
        if( $userId && (int)$userId !== 0 ){
            $this->salesrepCustomerResource->_addUserToCustomer($customerId, $userId);
        }
    }
}










