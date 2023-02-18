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
 * @package    Lof_SalesRepCompatible
 * @copyright  Copyright (c) 2020 Landofcoder (https://www.landofcoder.com/)
 * @license    https://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\SalesRepCompatible\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;

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

        /**
        * Create table 'lof_salesrep_quote_message'
        */
        $setup->getConnection()->dropTable($setup->getTable('lof_salesrep_quote_message'));
        $table_lof_salesrep_quote_message = $setup->getConnection()->newTable($setup->getTable('lof_salesrep_quote_message'));
        $table_lof_salesrep_quote_message->addColumn(
            'message_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true],
            'Entity ID'
        )->addColumn(
            'quote_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Quote Id'
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
            $installer->getFkName('lof_salesrep_quote_message', 'customer_id', 'customer_entity', 'entity_id'),
            'customer_id',
            $installer->getTable('customer_entity'),
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('lof_salesrep_quote_message', 'user_id', 'admin_user', 'user_id'),
            'user_id',
            $installer->getTable('admin_user'),
            'user_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Lof SalesRep Quote Message'
        );

        /**
        * Create table 'lof_salesrep_quote_comment_history'
        */
        $setup->getConnection()->dropTable($setup->getTable('lof_salesrep_quote_comment_history'));
        $table_lof_salesrep_comment_history = $setup->getConnection()->newTable($setup->getTable('lof_salesrep_quote_comment_history'));
        $table_lof_salesrep_comment_history->addColumn(
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true],
            'Sales Rep Quote ID'
        )->addColumn(
            'quote_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false,'unsigned' => true],
            'Quote ID'
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
        )->addColumn(
            'use_for_quote',
            \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
            null,
            [
                'nullable' => true,
                'default' => 0
            ],
            'Quote Comment'
        )->setComment(
            'Lof SalesRep Quote Comment History'
        );

        $setup->getConnection()->createTable($table_lof_salesrep_quote_message);
        $setup->getConnection()->createTable($table_lof_salesrep_comment_history);
        $setup->endSetup();
    }
}
