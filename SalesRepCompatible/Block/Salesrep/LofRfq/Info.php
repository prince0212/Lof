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
 * @copyright  Copyright (c) 2020 Landofcoder (https://www.landofcoder.com/)
 * @license    https://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\SalesRepCompatible\Block\Salesrep\LofRfq;

class Info extends \Magento\Framework\View\Element\Template
{
    protected $_userCollectionFactory;
    protected $_quoteFactory;
    protected $userFactory;
    protected $_currentCustomer;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\User\Model\ResourceModel\User\CollectionFactory $userCollectionFactory,
        \Magento\User\Model\UserFactory $userFactory,
        \Lof\SalesRepCompatible\Model\QuoteFactory $quoteFactory,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        array $data = []
    )
    {
        $this->_userCollectionFactory               = $userCollectionFactory;
        $this->_quoteFactory                        = $quoteFactory;
        $this->_currentCustomer                     = $currentCustomer;
        $this->userFactory                          = $userFactory;
        parent::__construct($context, $data);
    }
    public function getSalesRep(){
        return $this->_userCollectionFactory->create()
                ->addFieldToFilter('is_salesrep', array('eq' => 1))
                ->addFieldToFilter('is_active', 1)
                ->load();
    }

    public function getCurrentQuote(){
        $quoteId = $this->getRequest()->getParams('quote_id)');
        $quote       = $this->_quoteFactory->create()->load($quoteId);
        return $quote;
    }

    public function getUser(){
        $userId     = $this->getCurrentQuote()->getSalesrepId();
        $userInfo   = $this->userFactory->create()->load($userId);
        return $userInfo;
    }
}
