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

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class UpgradeSchema
 * @package Lof\SalesRep\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.5', '<')) {
            $tableQuote = $setup->getTable('sales_order');
            $tableInvoice = $setup->getTable('sales_invoice');
            $tableInvoiceGrid = $setup->getTable('sales_invoice_grid');
            $tableShipment = $setup->getTable('sales_shipment');
            $tableShipmentGrid = $setup->getTable('sales_shipment_grid');
            $tableCreditMemo = $setup->getTable('sales_creditmemo');
            $tableCreditMemoGrid = $setup->getTable('sales_creditmemo_grid');
            $tableSalesCreated = $setup->getTable('sales_order_aggregated_created');
            $tableSalesUpdated = $setup->getTable('sales_order_aggregated_updated');
            $setup->getConnection()->addColumn(
                $tableSalesCreated,
                'salesrep_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Sales Rep Id',
                    'default' => 0
                ]
            );

            $setup->getConnection()->addColumn(
                $tableSalesUpdated,
                'salesrep_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Sales Rep Id',
                    'default' => 0
                ]
            );

            $setup->getConnection()->addColumn(
                $tableInvoice,
                'salesrep_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Sales Rep Id',
                    'default' => 0
                ]
            );

            $setup->getConnection()->addColumn(
                $tableInvoice,
                'assign_salesrep_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Assign Sales Rep Id',
                    'default' => 0
                ]
            );
            $setup->getConnection()->addColumn(
                $tableInvoiceGrid,
                'salesrep_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Sales Rep Id',
                    'default' => 0
                ]
            );
            $setup->getConnection()->addColumn(
                $tableInvoiceGrid,
                'assign_salesrep_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Assign Sales Rep Id',
                    'default' => 0
                ]
            );
            $setup->getConnection()->addColumn(
                $tableShipment,
                'salesrep_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Sales Rep Id',
                    'default' => 0
                ]
            );
            $setup->getConnection()->addColumn(
                $tableShipment,
                'assign_salesrep_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Assign Sales Rep Id',
                    'default' => 0
                ]
            );
            $setup->getConnection()->addColumn(
                $tableShipmentGrid,
                'salesrep_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Sales Rep Id',
                    'default' => 0
                ]
            );
            $setup->getConnection()->addColumn(
                $tableShipmentGrid,
                'assign_salesrep_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Assign Sales Rep Id',
                    'default' => 0
                ]
            );
            $setup->getConnection()->addColumn(
                $tableCreditMemo,
                'salesrep_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Sales Rep Id',
                    'default' => 0
                ]
            );
            $setup->getConnection()->addColumn(
                $tableCreditMemo,
                'assign_salesrep_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Assign Sales Rep Id',
                    'default' => 0
                ]
            );
            $setup->getConnection()->addColumn(
                $tableCreditMemoGrid,
                'salesrep_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Sales Rep Id',
                    'default' => 0
                ]
            );
            $setup->getConnection()->addColumn(
                $tableCreditMemoGrid,
                'assign_salesrep_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Assign Sales Rep Id',
                    'default' => 0
                ]
            );
            $setup->getConnection()->addColumn(
                $tableQuote,
                'salesrep_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Sales Rep Id',
                    'default' => 0
                ]
            );
            $setup->getConnection()->addColumn(
                $tableQuote,
                'assign_salesrep_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Assign Sales Rep Id',
                    'default' => 0
                ]
            );


            $tableQuote = $setup->getTable('sales_order_grid');
            $setup->getConnection()->addColumn(
                $tableQuote,
                'salesrep_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Sales Rep Id',
                    'default' => 0
                ]
            );
            $setup->getConnection()->addColumn(
                $tableQuote,
                'assign_salesrep_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'nullable' => true,
                    'comment' => 'Assign Sales Rep Id',
                    'default' => 0
                ]
            );

            $tableQuote = $setup->getTable('lof_salesrep_order_comment_history');
            $setup->getConnection()->addColumn(
                $tableQuote,
                'use_for_order',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    'nullable' => true,
                    'comment' => 'Order Comment',
                    'default' => 0
                ]
            );

            $tableAdmins = $setup->getTable('admin_user');
            $setup->getConnection()->addColumn(
                $tableAdmins,
                'salesrep_av_group',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 100,
                    'nullable' => true,
                    'default' => '',
                    'comment' => 'Sales reps available for customer group. Empty for all'
                ]
            );

            $setup->getConnection()->addColumn(
                $tableAdmins,
                'salesrep_phone',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 100,
                    'nullable' => true,
                    'default' => '',
                    'comment' => 'Sales reps phone number'
                ]
            );
            $setup->getConnection()->addColumn(
                $tableAdmins,
                'salesrep_display_name',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 150,
                    'nullable' => true,
                    'default' => '',
                    'comment' => 'Sales reps display name'
                ]
            );
            $setup->getConnection()->addColumn(
                $tableAdmins,
                'salesrep_avatar',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 150,
                    'nullable' => true,
                    'default' => '',
                    'comment' => 'Sales reps avatar'
                ]
            );
            $setup->getConnection()->addColumn(
                $tableAdmins,
                'salesrep_address',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 250,
                    'nullable' => true,
                    'default' => '',
                    'comment' => 'Sales reps address'
                ]
            );
            $setup->getConnection()->addColumn(
                $tableAdmins,
                'salesrep_country',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 100,
                    'nullable' => true,
                    'default' => '',
                    'comment' => 'Sales reps country'
                ]
            );
            $setup->getConnection()->addColumn(
                $tableAdmins,
                'salesrep_postcode',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 100,
                    'nullable' => true,
                    'default' => '',
                    'comment' => 'Sales reps postcode'
                ]
            );
            $setup->getConnection()->addColumn(
                $tableAdmins,
                'salesrep_city_state',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 100,
                    'nullable' => true,
                    'default' => '',
                    'comment' => 'Sales reps city state'
                ]
            );
        }

        $setup->endSetup();
    }
}
