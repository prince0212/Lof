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

namespace Lof\SalesRep\Block\Adminhtml\SalesOrder\OrderAssign;

/**
 * Class History
 *
 * @package Lof\SalesRep\Block\Adminhtml\SalesOrder\OrderAssign
 */
class History extends \Magento\Backend\Block\Template {
    /**
     * @var \Magento\User\Model\ResourceModel\User\CollectionFactory
     */
    protected $_userCollectionFactory;

    /**
     * @var \Magento\User\Model\ResourceModel\User\CollectionFactory
     */
    protected $_salesrepCustomerCollectionFactory;

    /**
     * @var \Magento\User\Model\UserFactory
     */
    protected $_userFactory;

    /**
     * @var \Lof\SalesRep\Model\ResourceModel\CommentHistory\CollectionFactory
     */
    protected $_historyCollectionFactory;
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * Sales data
     *
     * @var \Magento\Sales\Helper\Data
     */
    protected $_salesData = null;

    /**
     * @var \Magento\Sales\Helper\Admin
     */
    private $adminHelper;

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $_authSession;
    /**
     * @var \Lof\SalesRep\Model\Permission\PermissionManagement
     */
    protected $_permissionManagement;

    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $_orderFactory;

    /**
     * History constructor.
     *
     * @param \Magento\Backend\Block\Template\Context                              $context
     * @param \Magento\Sales\Helper\Data                                           $salesData
     * @param \Magento\Framework\Registry                                          $registry
     * @param \Magento\Sales\Helper\Admin                                          $adminHelper
     * @param \Magento\User\Model\ResourceModel\User\CollectionFactory             $userCollectionFactory
     * @param \Magento\User\Model\UserFactory                                      $userFactory
     * @param \Magento\Sales\Model\OrderFactory                                    $orderFactory
     * @param \Magento\Backend\Model\Auth\Session                                  $authSession
     * @param \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer\CollectionFactory $salesrepCustomerCollectionFactory
     * @param \Lof\SalesRep\Model\ResourceModel\CommentHistory\CollectionFactory   $historyCollectionFactory
     * @param \Lof\SalesRep\Model\Permission\PermissionManagement                  $permissionManagement
     * @param array                                                                $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Sales\Helper\Data $salesData,
        \Magento\Framework\Registry $registry,
        \Magento\Sales\Helper\Admin $adminHelper,
        \Magento\User\Model\ResourceModel\User\CollectionFactory $userCollectionFactory,
        \Magento\User\Model\UserFactory $userFactory,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer\CollectionFactory $salesrepCustomerCollectionFactory,
        \Lof\SalesRep\Model\ResourceModel\CommentHistory\CollectionFactory $historyCollectionFactory,
        \Lof\SalesRep\Model\Permission\PermissionManagement $permissionManagement,
        array $data = []
    )
    {
        $this->_coreRegistry = $registry;
        $this->_salesData    = $salesData;
        parent::__construct($context, $data);
        $this->adminHelper                        = $adminHelper;
        $this->_userCollectionFactory             = $userCollectionFactory;
        $this->_userFactory                       = $userFactory;
        $this->_orderFactory                      = $orderFactory;
        $this->_authSession                       = $authSession;
        $this->_salesrepCustomerCollectionFactory = $salesrepCustomerCollectionFactory;
        $this->_historyCollectionFactory          = $historyCollectionFactory;
        $this->_permissionManagement              = $permissionManagement;
    }

    /**
     * Preparing global layout
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        $onclick = "submitAndReloadArea($('order_assign_history_block').parentNode, '" . $this->getSubmitUrl() . "');";
        $button  = $this->getLayout()->createBlock(
            \Magento\Backend\Block\Widget\Button::class
        )->setData(
            ['label' => __('Assign Sales Rep & Submit Comment'), 'class' => 'action-save action-secondary', 'onclick' => $onclick]
        );

        $this->setChild('submit_button', $button);

        return parent::_prepareLayout();
    }

    /**
     * @return \Magento\User\Model\ResourceModel\User\Collection
     */
    public function getSalesRep()
    {
        if ($this->_permissionManagement->allowAssignOtherDealer('general/see_other_dealers')) {
            $salesrep = $this->_userCollectionFactory->create()
                                                     ->addFieldToFilter('is_salesrep', ['eq' => 1])
                                                     ->addFieldToFilter('is_active', 1)
                                                     ->load();
        } else {
            $userId   = $this->_authSession->getUser()->getId();
            $salesrep = $this->_userCollectionFactory->create()
                                                     ->addFieldToFilter('is_salesrep', ['eq' => 1])
                                                     ->addFieldToFilter('user_id', ['eq' => $userId])
                                                     ->addFieldToFilter('is_active', 1)
                                                     ->load();
        }

        return $salesrep;
    }

    /**
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        $order = $this->_orderFactory->create()->load($this->getRequest()->getParam('order_id'));

        return $order;

    }

    /**
     * Return collection of order status history items.
     *
     * @return HistoryCollection
     */
    public function getCommentHistoryCollection()
    {
        $collection = $this->_historyCollectionFactory->create()
                                                      ->addFieldToFilter('order_id', ['eq' => $this->getOrder()->getId()])
                                                      ->addFieldToFilter('use_for_order', ['eq' => true])
                                                      ->load();

        return $collection;
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
        return $this->getUrl('lof_salesrep/salesrep_order/addComment', ['order_id' => $this->getOrder()->getId(), '_current' => true]);
    }

    /**
     * Replace links in string
     *
     * @param array|string $data
     * @param null|array   $allowedTags
     * @return string
     */
    public function escapeHtml($data, $allowedTags = null)
    {
        return $this->adminHelper->escapeHtmlWithLinks($data, $allowedTags);
    }
}
