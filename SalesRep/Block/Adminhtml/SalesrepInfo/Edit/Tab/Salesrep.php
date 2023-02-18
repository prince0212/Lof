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

namespace Lof\SalesRep\Block\Adminhtml\SalesrepInfo\Edit\Tab;
use Magento\Customer\Controller\RegistryConstants;
use Magento\Ui\Component\Layout\Tabs\TabInterface;

/**
 * Class Salesrep
 * @package Lof\SalesRep\Block\Adminhtml\SalesrepInfo\Edit\Tab
 */
class Salesrep  extends \Magento\Framework\View\Element\Template implements TabInterface
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
     * Salesrep constructor.
     *
     * @param \Magento\Backend\Block\Template\Context             $context
     * @param \Magento\Framework\Registry                         $registry
     * @param \Lof\SalesRep\Model\Permission\PermissionManagement $permissionManagement
     * @param array                                               $data
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
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->_coreRegistry->registry(RegistryConstants::CURRENT_CUSTOMER_ID);
    }
    /**
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Sales Representative');
    }
    /**
     * @return \Magento\Framework\Phrase
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
        if ($this->_permissionManagement->allowShowTab('Lof_SalesRep::salesrep_on_customer', 'general/show_salesrep_tab_in_customer')) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        if ($this->_permissionManagement->allowShowTab('Lof_SalesRep::salesrep_on_customer', 'general/show_salesrep_tab_in_customer')) {
            return false;
        }
        return true;
    }
    /**
     * Tab class getter
     *
     * @return string
     */
    public function getTabClass()
    {
        return '';
    }
    /**
     * Return URL link to Tab content
     *
     * @return string
     */
    public function getTabUrl()
    {
    //replace the tab with the url you want
        return $this->getUrl('lof_salesrep/salesrep/customer', ['_current' => true]);
    }
    /**
     * Tab should be loaded trough Ajax call
     *
     * @return bool
     */
    public function isAjaxLoaded()
    {
        return true;
    }
}
