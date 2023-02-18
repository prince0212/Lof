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
 * @package    Lof_SalesRepCompatible
 * @copyright  Copyright (c) 2019 Landofcoder (https://www.landofcoder.com/)
 * @license    https://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\SalesRepCompatible\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

class SalesRepQuote implements ObserverInterface
{
    /**
     * SalesRep resource model
     *
     * @var \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer
     */
    protected $_salesrepCustomerFactory; 
    /** 
     * @param \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer $salesrepCustomerResource,
     */
    public function __construct( 
        \Lof\SalesRep\Model\SalesrepCustomerFactory $_salesrepCustomerFactory
    ) { 
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
        $user = $observer->getEvent()->getObject();
        $quote = $observer->getData('lof_quote');
        $customerId  = $quote->getCustomerId();
        $userId = $this->getCurrentSalerep($customerId);
        if(isset($userId) && $userId !== null){
            $quote->setSalesrepId($userId);
            $quote->setAssignSalesrepId($userId);
        }else{
            $quote->setSalesrepId(0);
            $quote->setAssignSalesrepId(0);
        }
        $quote->save();
    }

    protected function getCurrentSalerep($customerId){  
        $users = $this->_salesrepCustomerFactory->create()->getCollection()->addFieldToFilter('customer_id', array('eq' => $customerId))->load();
        if($users && count($users) > 0){ 
            return $users->getFirstItem()->getUserId(); 
        }
        return null;
    }
}










