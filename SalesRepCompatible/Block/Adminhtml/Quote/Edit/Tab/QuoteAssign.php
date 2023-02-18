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

namespace Lof\SalesRepCompatible\Block\Adminhtml\Quote\Edit\Tab;

use \Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Sales\Model\Order;

/**
 * Class QuoteAssign
 * @package Lof\SalesRepCompatible\Block\Adminhtml\Quote\Edit\Tab
 */
class QuoteAssign extends \Magento\Framework\View\Element\Template implements TabInterface
{

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Lof\SalesRep\Model\Permission\PermissionManagement
     */
    protected $_permissionManagement;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Lof\SalesRep\Model\Permission\PermissionManagement $permissionManagement,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_permissionManagement = $permissionManagement;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve available order
     *
     * @return Order
     */
    public function getQuote()
    {
        return $this->_coreRegistry->registry('quotation_quote');
    }

    /**
     * Retrieve order model instance
     *
     * @return Order
     */
    public function getMageQuote()
    {
        return $this->_coreRegistry->registry('mage_quote');
    }

    /**
     * Retrieve source model instance
     *
     * @return Order
     */
    public function getSource()
    {
        return $this->getQuote();
    }


    /**
     * Retrieve order totals block settings
     *
     * @return array
     */
    public function getOrderTotalData()
    {
        return [
        'can_display_total_due' => true,
        'can_display_total_paid' => true,
        'can_display_total_refunded' => true
        ];
    }

    /**
     * Get order info data
     *
     * @return array
     */
    public function getOrderInfoData()
    {
        return ['no_use_order_link' => true];
    }

    /**
     * ######################## TAB settings #################################
     */

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Assign Sales Representative');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Sales Representative');
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        if ($this->_permissionManagement->allowShowTab('Lof_SalesRep::comment', 'general/show_assign_tab')) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        if ($this->_permissionManagement->allowShowTab('Lof_SalesRep::comment', 'general/show_assign_tab')) {
            return false;
        }
        return true;
    }
}
