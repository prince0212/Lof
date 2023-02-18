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

namespace Lof\SalesRep\Block\Adminhtml\Salesrep\Edit\Tab\Grid;

use Magento\Backend\Block\Widget\Grid\Column;

/**
 * @api
 * @since 100.0.2
 */
class Rfq extends \Magento\Backend\Block\Widget\Grid\Extended
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
     * @var \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer\CollectionFactory
     */
    protected $salesrepCustomerCollectionFactory;
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
        \Lof\SalesRep\Model\ResourceModel\SalesrepCustomer\CollectionFactory $salesrepCustomerCollectionFactory,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        $this->_jsonEncoder = $jsonEncoder;
        $this->_userRolesFactory = $userRolesFactory;
        $this->_customerFactory = $customerFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->salesrepCustomerCollectionFactory    = $salesrepCustomerCollectionFactory;
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
        $this->setDefaultSort('customer_id');
        $this->setDefaultDir('asc');
        $this->setId('userCustomerGrid');
        $this->setUseAjax(true);
    }

    /**
     * @param Column $column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'assigned_user_customer') {
            $userCustomer = $this->getSelectedCustomer();
            if (empty($userCustomer)) {
                $userCustomer = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', ['in' => $userCustomer]);
            } else {
                if ($userCustomer) {
                    $this->getCollection()->addFieldToFilter('entity_id', ['nin' => $userCustomer]);
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {   $userId = $this->getRequest()->getParam('user_id');
        $this->_coreRegistry->register('userId', $userId);
        $collection = $this->_customerFactory->create();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'assigned_user_customer',
            [
                'header_css_class' => 'a-center',
                'header' => __('Assigned'),
                'type' => 'checkbox',
                'values' => $this->getSelectedCustomer(),
                'align' => 'center',
                'index' => 'entity_id'
            ]
        );

        $this->addColumn(
            'user_customer_id',
            ['header' => __('User ID'), 'width' => 5, 'align' => 'left', 'sortable' => true, 'index' => 'entity_id']
        );

        $this->addColumn(
            'user_customer_firstname',
            ['header' => __('First Name'), 'align' => 'left', 'index' => 'firstname']
        );

        $this->addColumn(
            'user_customer_lastname',
            ['header' => __('Last Name'), 'align' => 'left', 'index' => 'lastname']
        );

        $this->addColumn(
            'user_customer_email',
            ['header' => __('Email'), 'align' => 'left', 'index' => 'email']
        );
        $this->addColumn(
            'customer_group',
            [
                'header'    => __('Customer Group'),
                'align'     => 'left',
                'type'      => 'options',
                'filter'    => \Lof\SalesRep\Block\Adminhtml\Salesrep\Edit\Tab\Customer\Grid\Filter\CustomerGroup::class,
                'index'     => 'group_id',
                'renderer'  => \Lof\SalesRep\Block\Adminhtml\Salesrep\Edit\Tab\Customer\Grid\Renderer\CustomerGroup::class
            ]
        );
        $this->addColumn(
            'user_customer_is_active',
            [
                'header'    => __('Status'),
                'index'     => 'is_active',
                'align'     => 'left',
                'type'      => 'options',
                'options'   => ['1' => __('Active'), '0' => __('Inactive')]
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        $userPermissions = $this->_coreRegistry->registry('permissions_user');
        return $this->getUrl('lof_salesrep/salesrep/customerGrid', ['user_id' => $userPermissions->getUserId()]);
    }

    /**
     * @param bool $json
     * @return array|mixed|string
     */
    public function getSelectedCustomer($json = false)
    {
        if ($this->getRequest()->getParam('in_salesrep_customer') != "") {
            return $this->getRequest()->getParam('in_salesrep_customer');
        }
        $userId = $this->getRequest()->getParam(
            'user_id'
        ) > 0 ? $this->getRequest()->getParam(
            'user_id'
        ) : $this->_coreRegistry->registry(
            'userId'
        );
        $result = $this->salesrepCustomerCollectionFactory->create()->addFieldToFilter('user_id', array('eq' => $userId))->load();
        $customerIds = [];
        foreach ($result as $key => $value) {
            $customerIds[] = $value['customer_id'];
        }
        if (sizeof($customerIds) > 0) {
            if ($json) {
                $jsonCustomers = [];
                foreach ($customerIds as $customerId) {
                    $jsonCustomers[$customerId] = 0;
                }
                return $this->_jsonEncoder->encode((object)$jsonCustomers);
            } else {
                return array_values($customerIds);
            }
        } else {
            if ($json) {
                return '{}';
            } else {
                return [];
            }
        }
    }
}
