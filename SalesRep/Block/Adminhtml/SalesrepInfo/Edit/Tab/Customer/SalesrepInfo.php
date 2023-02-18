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

namespace Lof\SalesRep\Block\Adminhtml\SalesrepInfo\Edit\Tab\Customer;

use Magento\Framework\Locale\OptionInterface;

/**
 * Class SalesrepInfo
 *
 * @package Lof\SalesRep\Block\Adminhtml\SalesrepInfo\Edit\Tab\Customer
 */
class SalesrepInfo extends \Lof\SalesRep\Block\Adminhtml\SalesrepInfo\Edit\Tab\SalesrepInfoParent {
    /**
     * @var \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer\CollectionFactory
     */
    protected $_salesrepCustomerCollectionFactory;

    /**
     * SalesrepInfo constructor.
     *
     * @param \Magento\Backend\Block\Template\Context                              $context
     * @param \Magento\Framework\Registry                                          $registry
     * @param \Magento\Framework\Data\FormFactory                                  $formFactory
     * @param \Magento\Backend\Model\Auth\Session                                  $authSession
     * @param \Magento\Framework\Locale\ListsInterface                             $localeLists
     * @param \Magento\Cms\Model\Wysiwyg\Config                                    $wysiwygConfig
     * @param \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer\CollectionFactory $salesrepCustomerCollectionFactory
     * @param \Magento\User\Model\UserFactory                                      $userFactory
     * @param array                                                                $data
     * @param \Magento\Framework\Locale\OptionInterface|null                       $deployedLocales
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Framework\Locale\ListsInterface $localeLists,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer\CollectionFactory $salesrepCustomerCollectionFactory,
        \Magento\User\Model\UserFactory $userFactory,
        array $data = [],
        OptionInterface $deployedLocales = null
    )
    {
        parent::__construct($context, $registry, $formFactory, $authSession, $localeLists, $wysiwygConfig, $userFactory, $data, $deployedLocales);
        $this->_salesrepCustomerCollectionFactory = $salesrepCustomerCollectionFactory;
    }

    /**
     * @return |null
     */
    protected function getCurrentSalerep()
    {
        $customerId = $this->getRequest()->getParam('id');
        $user       = $this->_salesrepCustomerCollectionFactory->create()->addFieldToFilter('customer_id', ['eq' => $customerId])->load();
        if ($user->getFirstItem()) {
            return $user->getFirstItem()->getUserId();
        }

        return null;
    }
}
