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

namespace Lof\SalesRep\Block\Adminhtml\Salesrep\Edit\Tab;

/**
 * Class Customer
 * @package Lof\SalesRep\Block\Adminhtml\Salesrep\Edit\Tab
 */
class Customer extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * User model factory
     *
     * @var \Magento\User\Model\ResourceModel\User\CollectionFactory
     */
    protected $_customerCollectionFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory,
        array $data = []
    ) {
        // _userCollectionFactory is used in parent::__construct
        $this->_customerCollectionFactory = $customerCollectionFactory;
        parent::__construct($context, $jsonEncoder, $authSession, $data);
    }

    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();

        $userId = $this->getRequest()->getParam('user_id', false);
        /** @var \Magento\User\Model\ResourceModel\User\Collection $users */
        $customers = $this->_customerCollectionFactory->create()->load();
        $this->setTemplate('user/customer.phtml')->assign('customers', $customers->getItems())->assign('userId', $userId);
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {

        $this->setChild(
            'customersGrid',
            $this->getLayout()->createBlock(\Lof\SalesRep\Block\Adminhtml\Salesrep\Edit\Tab\Grid\Customer::class, 'userCustomersGrid')
        );
        return parent::_prepareLayout();
    }

    /**
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getChildHtml('customersGrid');
    }
}
