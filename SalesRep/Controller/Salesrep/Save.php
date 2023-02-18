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

namespace  Lof\SalesRep\Controller\Salesrep;

use Lof\SalesRep\Model\ResourceModel\SalesrepCustomer;
use Lof\SalesRep\Model\ResourceModel\SalesrepCustomer\CollectionFactory;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\App\Action\Context;
use Magento\User\Model\User;

/**
 * Class Save
 * @package Lof\SalesRep\Controller\Salesrep
 */
class Save extends \Magento\Framework\App\Action\Action
{
    /**
     * @var CurrentCustomer
     */
    protected $_currentCustomer;

    /**
     * @var SalesrepCustomer
     */
    protected $salesrepResource;

    /**
     * @var CollectionFactory
     */
    protected $salesrepCustomerCollectionFactory;
    /**
     * @var User
     */
    private $user;

    /**
     * @param Context $context
     * @param CollectionFactory $salesrepCustomerCollectionFactory
     * @param SalesrepCustomer $salesrepResource
     * @param CurrentCustomer $currentCustomer
     * @param User $user
     */
    public function __construct(
        Context $context,
        CollectionFactory $salesrepCustomerCollectionFactory,
        SalesrepCustomer $salesrepResource,
        CurrentCustomer $currentCustomer,
        User $user
    ) {
        parent::__construct($context);
        $this->salesrepCustomerCollectionFactory    = $salesrepCustomerCollectionFactory;
        $this->salesrepResource                     = $salesrepResource;
        $this->_currentCustomer                     = $currentCustomer;
        $this->user                                 = $user;
    }

    /**
     * Change customer email or password action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $salesrepId         = $this->getRequest()->getPost('dealer_id');
        $adminUser          = $this->user->load($salesrepId);
        if(!$adminUser->getIsSalesrep()) {
            $this->messageManager->addErrorMessage(__('The Sales Representative you have selected does not exist.'));
        } else {
            $customerId = $this->_currentCustomer->getCustomerId();
            $this->salesrepResource->_deleteCustomer( $customerId );
            if( $salesrepId && (int)$salesrepId !== 0 ){
                $this->salesrepResource->_addUserToCustomer( $customerId, $salesrepId );
            }
            $this->messageManager->addSuccess(__('You saved dealer.'));
        }
        $this->_redirect( 'lof_salesrep/salesrep/' );
    }
}
