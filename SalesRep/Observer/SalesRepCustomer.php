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
 * Class SalesRepCustomer
 * @package Lof\SalesRep\Observer
 */
class SalesRepCustomer implements ObserverInterface
{
    /**
     * SalesRep resource model
     *
     * @var \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer
     */
    protected $salesrepCustomerResource;


    /**
     * @var \Lof\SalesRep\Helper\Data
     */
    protected $_salesrepHelper;
    /**
     * @param \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer $salesrepCustomerResource
     * @param \Lof\SalesRep\Helper\Data $salesrepHelper
     */
    public function __construct(
        \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer $salesrepCustomerResource,
        \Lof\SalesRep\Helper\Data $salesrepHelper
    ) {
        $this->salesrepCustomerResource         = $salesrepCustomerResource;
        $this->_salesrepHelper                  = $salesrepHelper;
    }

    /**
     * Save current admin password to prevent its usage when changed in the future.
     *
     * @param EventObserver $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {
        /* @var $user \Magento\User\Model\User */
        $user = $observer->getEvent()->getObject();
        $userCustomer = $user->getInSalesrepCustomer();
        if($userCustomer){
        parse_str($userCustomer, $userCustomer);
        if( $user->getCheckUserSave() ){
            if( $user->getIsSalesrep() == 1 ){
                // add sales rep customer
                $userCustomer = array_keys($userCustomer);
                $this->salesrepCustomerResource->_deleteUserToCustomer($user->getId());
                $this->salesrepCustomerResource->_addSalesRepInfo( $user->getIsSalesrep(), $user->getSalesrepInfo(), $user->getId(), $user->getBccEmail() );
                foreach ($userCustomer as $customerId) {
                    $this->salesrepCustomerResource->_deleteCustomer($customerId);
                    $this->salesrepCustomerResource->_addUserToCustomer($customerId, $user->getId());
                }
            }else{
                $this->salesrepCustomerResource->_deleteUserToCustomer($user->getId());
            }
        }
    }
    }
}










