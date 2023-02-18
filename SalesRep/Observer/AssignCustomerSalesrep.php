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

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\User\Model\User;
/**
 * Class AssignCustomerSalesrep
 * @package Lof\SalesRep\Observer
 */
class AssignCustomerSalesrep implements ObserverInterface
{
    /**
     * SalesRep resource model
     *
     * @var \Lof\SalesRep\Model\ResourceModel\Salesrep
     */
    protected $salesrepResource;

    /**
     * @var RequestInterface
     */
    protected $_request;
    /**
     * @var User
     */
    private $user;
    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * @param \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer $salesrepResource ,
     * @param RequestInterface $request
     * @param User $user
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer $salesrepResource,
        RequestInterface $request,
        User $user,
        ManagerInterface $messageManager
    ) {
        $this->salesrepResource = $salesrepResource;
        $this->_request = $request;
        $this->user = $user;
        $this->messageManager = $messageManager;
    }

    /**
     * Save current admin password to prevent its usage when changed in the future.
     *
     * @param EventObserver $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {
        $userId     =  $this->_request->getPost('dealer_id');
        $adminUser          = $this->user->load($userId);
        if(!$adminUser->getIsSalesrep()) {
            $this->messageManager->addErrorMessage(__('The Sales Representative you have selected does not exist.'));
        } else {
            $customerId = $observer->getEvent()->getCustomer()->getId();
            if( $userId && (int)$userId !== 0 ){
                $this->salesrepResource->_addUserToCustomer( $customerId, $userId );
            }
        }
    }
}
