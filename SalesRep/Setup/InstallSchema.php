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

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;

/**
 * Class InstallSchema
 * @package Lof\SalesRep\Setup
 */
class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        $tableAdmins = $installer->getTable('admin_user');

        $installer->getConnection()->addColumn(
            $tableAdmins,
            'salesrep_info',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'Additional Info'
            ]
        );
        $installer->getConnection()->addColumn(
            $tableAdmins,
            'is_salesrep',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'nullable' => true,
                'comment' => 'IS Sales Rep',
                'default' => 0
            ]
        );

        $installer->getConnection()->addColumn(
            $tableAdmins,
            'bcc_email',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'Bcc Email',
            ]
        );

        /**
        * Create table 'lof_salesrep_message'
        */
        $setup->getConnection()->dropTable($setup->getTable('lof_salesrep_message'));
        $table_lof_salesrep_message = $setup->getConnection()->newTable($setup->getTable('lof_salesrep_message'));
        $table_lof_salesrep_message->addColumn(
            'message_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true],
            'Entity ID'
        )->addColumn(
            'order_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'order_id'
        )->addColumn(
            'user_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'user_id'
        )->addColumn(
            'customer_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'customer_id'
        )->addColumn(
            'customer_email',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['unsigned' => false, 'nullable' => false],
            'Customer Email'
        )->addColumn(
            'customer_name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['unsigned' => false, 'nullable' => false],
            'Customer Name'
        )->addColumn(
            'content',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['unsigned' => false, 'nullable' => false],
            'content'
        )->addColumn(
            'created',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'created'
        )->addColumn(
            'modified',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'modified'
        )->addForeignKey(
            $installer->getFkName('lof_salesrep_message', 'order_id', 'sales_order', 'entity_id'),
            'order_id',
            $installer->getTable('sales_order'),
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('lof_salesrep_message', 'customer_id', 'customer_entity', 'entity_id'),
            'customer_id',
            $installer->getTable('customer_entity'),
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('lof_salesrep_message', 'user_id', 'admin_user', 'user_id'),
            'user_id',
            $installer->getTable('admin_user'),
            'user_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Lof SalesRep Message'
        );

        /**
        * Create table 'lof_salesrep_customer'
        */
        $setup->getConnection()->dropTable($setup->getTable('lof_salesrep_customer'));
        $table_lof_salesrep_customer = $setup->getConnection()->newTable($setup->getTable('lof_salesrep_customer'));
        $table_lof_salesrep_customer->addColumn(
            'salesrep_customer_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true],
            'Sales Rep Customer ID'
        )->addColumn(
            'user_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false,'unsigned' => true],
            'User ID'
        )->addColumn(
            'customer_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false,'unsigned' => true],
            'customer_id'
        )->addForeignKey(
            $installer->getFkName('lof_salesrep_customer', 'user_id', 'admin_user', 'user_id'),
            'user_id',
            $installer->getTable('admin_user'),
            'user_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('lof_salesrep_customer', 'customer_id', 'customer_entity', 'entity_id'),
            'customer_id',
            $installer->getTable('customer_entity'),
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Lof SalesRep Customer'
        );

        /**
        * Create table 'lof_salesrep_order'
        */
        $setup->getConnection()->dropTable($setup->getTable('lof_salesrep_order'));
        $table_lof_salesrep_order = $setup->getConnection()->newTable($setup->getTable('lof_salesrep_order'));
        $table_lof_salesrep_order->addColumn(
            'salesrep_order_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true],
            'Sales Rep Order ID'
        )->addColumn(
            'user_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false,'unsigned' => true],
            'User ID'
        )->addColumn(
            'order_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false,'unsigned' => true],
            'order_id'
        )->addForeignKey(
            $installer->getFkName('lof_salesrep_order', 'user_id', 'admin_user', 'user_id'),
            'user_id',
            $installer->getTable('admin_user'),
            'user_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('lof_salesrep_order', 'order_id', 'sales_order', 'entity_id'),
            'order_id',
            $installer->getTable('catalog_product_entity'),
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Lof SalesRep Order'
        );

        /**
        * Create table 'lof_salesrep_order_comment_history'
        */
        $setup->getConnection()->dropTable($setup->getTable('lof_salesrep_order_comment_history'));
        $table_lof_salesrep_comment_history = $setup->getConnection()->newTable($setup->getTable('lof_salesrep_order_comment_history'));
        $table_lof_salesrep_comment_history->addColumn(
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true],
            'Sales Rep Order ID'
        )->addColumn(
            'order_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false,'unsigned' => true],
            'Order ID'
        )->addColumn(
            'is_customer_notified',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [],
            'Is Customer Notified'
        )->addColumn(
            'comment',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'Comment'
        )->addColumn(
            'assign_from',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Status'
        )->addColumn(
            'assign_to',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Status'
        )->addColumn(
            'user_change',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Status'
        )->addColumn(
            'created_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'Created At'
        )->setComment(
            'Lof SalesRep Order Comment History'
        );

        /**
        * Create table 'lof_salesrep_order_log'
        */
        $setup->getConnection()->dropTable($setup->getTable('lof_salesrep_order_log'));
        $table_lof_salesrep_order_log = $setup->getConnection()->newTable($setup->getTable('lof_salesrep_order_log'));
        $table_lof_salesrep_order_log->addColumn(
            'log_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true],
            'Entity ID'
        )->addColumn(
            'order_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [],
            'order_id'
        )->addColumn(
            'user_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [],
            'user_id'
        )->addColumn(
            'content',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'content'
        )->addColumn(
            'created',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'created'
        )->addColumn(
            'modified',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'modified'
        );

        $setup->getConnection()->createTable($table_lof_salesrep_message);
        $setup->getConnection()->createTable($table_lof_salesrep_order_log);
        $setup->getConnection()->createTable($table_lof_salesrep_customer);
        $setup->getConnection()->createTable($table_lof_salesrep_order);
        $setup->getConnection()->createTable($table_lof_salesrep_comment_history);
        $setup->endSetup();
    }
}
