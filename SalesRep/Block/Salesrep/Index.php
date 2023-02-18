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

namespace Lof\SalesRep\Block\Salesrep;

/**
 * Class Index
 * @package Lof\SalesRep\Block\Salesrep
 */
class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\User\Model\ResourceModel\User\CollectionFactory
     */
    protected $_userCollectionFactory;
    /**
     * @var \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer\CollectionFactory
     */
    protected $salesrepCustomerCollectionFactory;
    /**
     * @var \Magento\User\Model\UserFactory
     */
    protected $userFactory;
    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    protected $_currentCustomer;

    /**
     * Index constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\User\Model\ResourceModel\User\CollectionFactory $userCollectionFactory
     * @param \Magento\User\Model\UserFactory $userFactory
     * @param \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer\CollectionFactory $salesrepCustomerCollectionFactory
     * @param \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\User\Model\ResourceModel\User\CollectionFactory $userCollectionFactory,
        \Magento\User\Model\UserFactory $userFactory,
        \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer\CollectionFactory $salesrepCustomerCollectionFactory,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        array $data = []
    )
    {
        $this->_userCollectionFactory               = $userCollectionFactory;
        $this->salesrepCustomerCollectionFactory    = $salesrepCustomerCollectionFactory;
        $this->_currentCustomer                     = $currentCustomer;
        $this->userFactory                          = $userFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\User\Model\ResourceModel\User\Collection
     */
    public function getSalesRep(){
        return $this->_userCollectionFactory->create()
                ->addFieldToFilter('is_salesrep', array('eq' => 1))
                ->addFieldToFilter('is_active', 1)
                ->load();
    }

    /**
     * @return \Magento\Framework\DataObject
     */
    public function getCurrentSalerep(){
        $customerId = $this->_currentCustomer->getCustomerId();
        $user       = $this->salesrepCustomerCollectionFactory->create()->addFieldToFilter('customer_id', array('eq' => $customerId))->load();
        return $user->getFirstItem();
    }

    /**
     * @return \Magento\User\Model\User
     */
    public function getUser(){
        $userId     = $this->getCurrentSalerep()->getUserId();
        $userInfo   = $this->userFactory->create()->load($userId);
        return $userInfo;
    }
}
