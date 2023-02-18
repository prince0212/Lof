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
 * @copyright  Copyright (c) 2020 Landofcoder (https://www.landofcoder.com/)
 * @license    https://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\SalesRepCompatible\Block\Adminhtml\Quote\QuoteAssign;

use Lof\SalesRepCompatible\Model\QuoteFactory;
use Lof\SalesRep\Model\Permission\PermissionManagement;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Registry;
use Magento\Sales\Helper\Admin;
use Magento\Sales\Helper\Data;
use Magento\User\Model\ResourceModel\User\CollectionFactory;
use Magento\User\Model\UserFactory;

class History extends \Magento\Backend\Block\Template
{
    /**
     * @var CollectionFactory
     */
    protected $_userCollectionFactory;

    /**
     * @var CollectionFactory
     */
    protected $_salesrepCustomerCollectionFactory;

    /**
     * @var UserFactory
     */
    protected $_userFactory;

    /**
     * @var QuoteFactory
     */
    protected $_quoteFactory;


    /**
     * @var \Lof\SalesRep\Model\ResourceModel\CommentHistory\CollectionFactory
     */
    protected $_historyCollectionFactory;
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $_coreRegistry = null;

    /**
     * Sales data
     *
     * @var Data
     */
    protected $_salesData = null;

    /**
     * @var Admin
     */
    private $adminHelper;

    /**
     * @var Session
     */
    protected $_authSession;
        /**
     * @var PermissionManagement
     */
    protected $_permissionManagement;

    /**
     * @param Context $context
     * @param Data $salesData
     * @param Registry $registry
     * @param Admin $adminHelper
     * @param CollectionFactory $userCollectionFactory
     * @param UserFactory $userFactory
     * @param QuoteFactory $quoteFactory
     * @param Session $authSession
     * @param \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer\CollectionFactory $salesrepCustomerCollectionFactory
     * @param \Lof\SalesRepCompatible\Model\ResourceModel\QuoteCommentHistory\CollectionFactory $historyCollectionFactory
     * @param PermissionManagement $permissionManagement
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $salesData,
        Registry $registry,
        Admin $adminHelper,
        CollectionFactory $userCollectionFactory,
        UserFactory $userFactory,
        QuoteFactory $quoteFactory,
        Session $authSession,
        \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer\CollectionFactory $salesrepCustomerCollectionFactory,
        \Lof\SalesRepCompatible\Model\ResourceModel\QuoteCommentHistory\CollectionFactory $historyCollectionFactory,
        PermissionManagement $permissionManagement,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_salesData = $salesData;
        parent::__construct($context, $data);
        $this->adminHelper = $adminHelper;
        $this->_userCollectionFactory               = $userCollectionFactory;
        $this->_userFactory                         = $userFactory;
        $this->_quoteFactory                        = $quoteFactory;
        $this->_authSession                         = $authSession;
        $this->_salesrepCustomerCollectionFactory   = $salesrepCustomerCollectionFactory;
        $this->_historyCollectionFactory            = $historyCollectionFactory;
        $this->_permissionManagement = $permissionManagement;
    }

    /**
     * Preparing global layout
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        $onclick = "submitAndReloadArea($('quote_assign_history_block').parentNode, '" . $this->getSubmitUrl() . "'); location.reload()";
        $button = $this->getLayout()->createBlock(
            \Magento\Backend\Block\Widget\Button::class
        )->setData(
            ['label' => __('Assign Sales Rep & Submit Comment'), 'class' => 'action-save action-secondary', 'onclick' => $onclick]
        );
        $this->setChild('submit_button', $button);
        return parent::_prepareLayout();
    }

    public function getSalesRep(){
        if( $this->_permissionManagement->allowAssignOtherDealer('general/see_other_dealers')){
            $salesrep = $this->_userCollectionFactory->create()
                            ->addFieldToFilter('is_salesrep', array('eq' => 1))
                            ->addFieldToFilter('is_active', 1)
                            ->load();
        }else{
            $userId   = $this->_authSession->getUser()->getId();
            $salesrep = $this->_userCollectionFactory->create()
                    ->addFieldToFilter('is_salesrep', array('eq' => 1))
                    ->addFieldToFilter('user_id', array('eq' => $userId))
                    ->addFieldToFilter('is_active', 1)
                    ->load();
        }

        return $salesrep;
    }

    public function getQuote(){
        $quote = $this->_quoteFactory->create()->load($this->getRequest()->getParam('entity_id'));
        return $quote;
    }

    /**
     * Return collection of order status history items.
     *
     * @return HistoryCollection
     */
    public function getCommentHistoryCollection()
    {
        $quoteId    = $this->getRequest()->getParam('entity_id');
        return $this->_historyCollectionFactory->create()
                            ->addFieldToFilter('quote_id', array('eq' => $quoteId))
                            ->addFieldToFilter('use_for_quote', array('eq' => false))
                            ->load();
    }

    /**
     * Check allow to add comment
     *
     * @return bool
     */
    public function canAddComment()
    {
        return $this->_authorization->isAllowed('Lof_SalesRep::comment');
    }

    /**
     * Submit URL getter
     *
     * @return string
     */
    public function getSubmitUrl()
    {
        $quoteId    = $this->getRequest()->getParam('entity_id');
        return $this->getUrl('lsrcompatible/salesrep/rfq_addComment' , ['quote_id' => $quoteId,  '_current' => true ]);
    }
    /**
     * Replace links in string
     *
     * @param array|string $data
     * @param null|array $allowedTags
     * @return string
     */
    public function escapeHtml($data, $allowedTags = null)
    {
        return $this->adminHelper->escapeHtmlWithLinks($data, $allowedTags);
    }
}
