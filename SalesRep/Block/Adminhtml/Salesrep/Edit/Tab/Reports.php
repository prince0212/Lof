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

use Magento\Backend\Block\Widget\Grid\Column;

/**
 * @api
 * @since 100.0.2
 */
class Reports extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Authorization\Model\ResourceModel\Role\CollectionFactory
     */
    protected $_userRolesFactory;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory
     */
    protected $_customerFactory;
    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $_jsonEncoder;
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    protected $_orderCollectionFactory;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Authorization\Model\ResourceModel\Role\CollectionFactory $userRolesFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Authorization\Model\ResourceModel\Role\CollectionFactory $userRolesFactory,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerFactory,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        $this->_jsonEncoder = $jsonEncoder;
        $this->_userRolesFactory = $userRolesFactory;
        $this->_customerFactory = $customerFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_orderCollectionFactory = $orderCollectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('salesrepReportsGrid');
        $this->setDefaultSort('sort_order');
        $this->setDefaultDir('asc');
        $this->setTitle(__('SalesRep Reports'));
        $this->setUseAjax(true);
    }
    /**
     * @param Column $column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        parent::_addColumnFilterToCollection($column);
    }
    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $orders = $this->_orderCollectionFactory->create()->addAttributeToSelect(
            '*'
        )->addAttributeToFilter(
            'salesrep_id',
            $this->getRequest()->getParam('user_id')
        )->addAttributeToSort(
            'created_at',
            'desc'
        )->load();
        $this->setCollection($orders);
        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {

        $this->addColumn(
            'o_increment_id',
            ['header' => __('Increment Id #'), 'align' => 'left', 'index' => 'increment_id']
        );

        $this->addColumn(
            'o_created_at',
            ['header' => __('Purchase On'), 'align' => 'left', 'index' => 'created_at']
        );


        // $this->addColumn(
        //     'billing_name',
        //     ['header' => __('Bill to Name'), 'align' => 'left', 'index' => 'billing_name']
        // );

        // $this->addColumn(
        //     'shipping_name',
        //     ['header' => __('Shipped to Name'), 'align' => 'left', 'index' => 'shipping_name']
        // );

        $this->addColumn(
            'o_base_grand_total',
            ['header' => __('Base Grand Total'), 'align' => 'left', 'index' => 'base_grand_total']
        );

        $this->addColumn(
            'o_base_discount_amount',
            ['header' => __('Base Discount Amount'), 'align' => 'left', 'index' => 'base_discount_amount']
        );

        $this->addColumn(
            'o_base_discount_canceled',
            ['header' => __('Base Discount Canceled'), 'align' => 'left', 'index' => 'base_discount_canceled']
        );

        $this->addColumn(
            'o_base_discount_invoiced',
            ['header' => __('Base Discount Invoiced'), 'align' => 'left', 'index' => 'base_discount_invoiced']
        );

        $this->addColumn(
            'o_base_discount_refunded',
            ['header' => __('Base Discount Refunded'), 'align' => 'left', 'index' => 'base_discount_refunded']
        );

        $this->addColumn(
            'o_base_shipping_amount',
            ['header' => __('Base Shipping Amount'), 'align' => 'left', 'index' => 'base_shipping_amount']
        );

        $this->addColumn(
            'o_base_shipping_canceled',
            ['header' => __('Base Shipping Canceled'), 'align' => 'left', 'index' => 'base_shipping_canceled']
        );

        $this->addColumn(
            'o_base_shipping_invoiced',
            ['header' => __('Base Shipping Invoiced'), 'align' => 'left', 'index' => 'base_shipping_invoiced']
        );

        $this->addColumn(
            'o_base_shipping_refunded',
            ['header' => __('Base Shipping Refunded'), 'align' => 'left', 'index' => 'base_shipping_refunded']
        );

        $this->addColumn(
            'o_base_shipping_tax_amount',
            ['header' => __('Base Shipping Tax Amount'), 'align' => 'left', 'index' => 'base_shipping_tax_amount']
        );

        $this->addColumn(
            'o_base_shipping_tax_refunded',
            ['header' => __('Base Shipping Tax Refunded'), 'align' => 'left', 'index' => 'base_shipping_tax_refunded']
        );

        $this->addColumn(
            'o_base_subtotal',
            ['header' => __('Base Subtotal'), 'align' => 'left', 'index' => 'base_subtotal']
        );

        $this->addColumn(
            'o_base_subtotal_canceled',
            ['header' => __('Base Subtotal Canceled'), 'align' => 'left', 'index' => 'base_subtotal_canceled']
        );

        $this->addColumn(
            'o_base_subtotal_invoiced',
            ['header' => __('Base Subtotal Invoiced'), 'align' => 'left', 'index' => 'base_subtotal_invoiced']
        );

        $this->addColumn(
            'o_base_subtotal_refunded',
            ['header' => __('Base Subtotal Refunded'), 'align' => 'left', 'index' => 'base_subtotal_refunded']
        );

        $this->addColumn(
            'o_base_tax_amount',
            ['header' => __('Base Tax Amount'), 'align' => 'left', 'index' => 'base_tax_amount']
        );

        $this->addColumn(
            'o_base_tax_canceled',
            ['header' => __('Base Tax Canceled'), 'align' => 'left', 'index' => 'base_tax_canceled']
        );

        $this->addColumn(
            'o_base_tax_invoiced',
            ['header' => __('Base Tax Invoiced'), 'align' => 'left', 'index' => 'base_tax_invoiced']
        );

        $this->addColumn(
            'o_base_tax_refunded',
            ['header' => __('Base Tax Refunded'), 'align' => 'left', 'index' => 'base_tax_refunded']
        );
        $this->addColumn(
            'o_status',
            ['header' => __('Status'), 'index' => 'status', 'type' => 'text']
        );

        $this->addExportType('lof_salesrep/salesrep_report/exportOrderCsv', __('CSV'));
        $this->addExportType('lof_salesrep/salesrep_report/exportOrderExcel', __('Excel XML'));

        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        $userPermissions = $this->_coreRegistry->registry('permissions_user');
        return $this->getUrl('lof_salesrep/salesrep_report/orderGrid', ['user_id' => $userPermissions->getUserId()]);
    }

}
