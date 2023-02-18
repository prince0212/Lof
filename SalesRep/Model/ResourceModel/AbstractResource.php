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

namespace Lof\SalesRep\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;

/**
 *
 *
 * @category Magestore
 * @package  Magestore_InventorySuccess
 * @module   Inventorysuccess
 * @author   Magestore Developer
 */
abstract class AbstractResource extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var \Lof\SalesRep\Helper\Mail
     */
    protected $_mailHelper;

    /**
     * @var \Lof\SalesRep\Helper\Data
     */
    protected $_salesrepHelper;

    /**
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param string $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Lof\SalesRep\Helper\Mail $mailHelper,
        \Lof\SalesRep\Helper\Data $salesrepHelper,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->_mailHelper  = $mailHelper;
        $this->_salesrepHelper  = $salesrepHelper;
    }

    /**
     * insert data to table.
     *
     * @param $table
     * @param array $data
     *
     * @throws LocalizedException
     */
    public function insertData($table, array $data = [])
    {
        if (empty($data)) {
            return;
        }

        $connection = $this->getConnection();
        $connection->beginTransaction();
        try {
            $connection->insertMultiple($table, $data);
            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollBack();
            throw new LocalizedException(__($e->getMessage()), $e);
        }
    }

    /**
     * delete data from table.
     *
     * @param $table
     * @param array $where
     *
     * @throws LocalizedException
     */
    public function deleteData($table, array $where = [])
    {
        if (empty($where)) {
            return;
        }

        $connection = $this->getConnection();
        $connection->beginTransaction();
        try {
            $connection->delete($table, $where);
            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollBack();
            throw new LocalizedException(__($e->getMessage()), $e);
        }
    }

    /**
     * update data for table.
     *
     * @param $table
     * @param $bind
     * @param $where
     *
     * @throws LocalizedException
     */
    public function updateData($table, $bind, $where = [])
    {
        if (empty($where)) {
            return;
        }

        $connection = $this->getConnection();
        $connection->beginTransaction();
        try {
            $connection->update($table, $bind, $where);
            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollBack();
            throw new LocalizedException(__($e->getMessage()), $e);
        }
    }
}
