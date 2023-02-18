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

namespace Lof\SalesRep\Setup;

use Exception;
use Magento\Authorization\Model\Acl\Role\Group as RoleGroup;
use Magento\Authorization\Model\UserContextInterface;
use \Magento\Framework\Setup\UpgradeDataInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Class UpgradeData
 *
 * @package Lof\SalesRep\Setup
 */
class UpgradeData implements UpgradeDataInterface {
    /**
     * @var \Magento\Authorization\Model\RoleFactory
     */
    private $roleFactory;

    /**
     * @var \Magento\Authorization\Model\RulesFactory
     */
    private $rulesFactory;

    /**
     * Init
     *
     * @param \Magento\Authorization\Model\RoleFactory  $roleFactory
     * @param \Magento\Authorization\Model\RulesFactory $rulesFactory
     */
    public function __construct(
        \Magento\Authorization\Model\RoleFactory $roleFactory,
        \Magento\Authorization\Model\RulesFactory $rulesFactory
    )
    {
        $this->roleFactory  = $roleFactory;
        $this->rulesFactory = $rulesFactory;
    }

    /**
     * Upgrade data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface   $context
     * @return void
     * @throws Exception
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.5', '<')) {
            $this->createSalesRepRole($setup);
        }
    }

    /**
     * @param $setup
     * @throws Exception
     */
    public function createSalesRepRole($setup)
    {
        /**
         * Create Warehouse role
         */
        $role = $this->roleFactory->create();
        $role->setName('SalesRep') //Set Role Name Which you want to create
             ->setPid(0) //set parent role id of your role
             ->setRoleType(RoleGroup::ROLE_TYPE)
             ->setUserType(UserContextInterface::USER_TYPE_ADMIN);
        $role->save();

        $resource = [
            'Magento_Backend::admin',
            'Magento_Sales::sales',
            'Magento_Sales::create',
            'Magento_Sales::actions_view',
            'Magento_Sales::email',
            'Magento_Sales::reorder',
            'Magento_Sales::actions_edit',
            'Magento_Sales::cancel',
            'Magento_Sales::review_payment',
            'Magento_Sales::capture',
            'Magento_Sales::invoice',
            'Magento_Sales::shipment',
            'Magento_Sales::sales_creditmemo',
            // 'Magento_Sales::transactions',
            'Magento_Sales::transactions_fetch',
            'Magento_Sales::creditmemo',
            'Magento_Sales::hold',
            'Magento_Sales::unhold',
            'Magento_Sales::ship',
            'Magento_Sales::comment',
            'Magento_Sales::emails',
            'Magento_Sales::sales_invoice',
            'Magento_Sales::sales_operation',
            'Magento_Sales::sales',
            'Magento_Sales::sales_order',
            'Magento_Sales::actions',
            // 'Magento_Paypal::authorization',
            // 'Magento_Paypal::billing_agreement',
            // 'Magento_Paypal::billing_agreement_actions',
            // 'Magento_Paypal::billing_agreement_actions_view',
            // 'Magento_Paypal::actions_manage',
            // 'Magento_Paypal::use',
            'Lof_SalesRep::lof_salesrep',
            'Lof_SalesRep::salesrep_permission',
            'Lof_SalesRep::salesrep_on_customer',
            'Lof_SalesRep::salesrep_on_invoice',
            'Lof_SalesRep::salesrep_on_shipment',
            'Lof_SalesRep::salesrep_on_creditmemo',
            'Lof_SalesRep::salesrep_edit_info',
            'Lof_SalesRep::creditmemo',
            'Lof_SalesRep::order',
            'Lof_SalesRep::invoice',
            'Lof_SalesRep::shipment',
            'Lof_SalesRep::comment',
            'Lof_SalesRep::report',
            'Lof_SalesRep::dashboard',
            'Lof_RequestForQuote::quote',
            'Lof_RequestForQuote::quote_create',
            'Lof_RequestForQuote::quote_edit',
            'Lof_RequestForQuote::quote_save',
            'Lof_RequestForQuote::quote_delete',
            'Lof_RequestForQuote::quote_export',
            'Magento_Backend::quote_elements',
            'Magento_Backend::lof_all_elements',
            'Lof_All::lof_all',
            'Magento_Customer::customer',
            'Magento_Customer::manage',
            'Magento_Customer::online',
            'Magento_Customer::group',
            'Magento_Reports::report',
            'Magento_Reports::statistics',
            'Magento_Reports::statistics_refresh',
        ];

        $this->rulesFactory->create()->setRoleId($role->getId())->setResources($resource)->saveRel();
    }
}
