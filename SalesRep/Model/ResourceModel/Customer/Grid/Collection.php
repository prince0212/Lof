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

namespace Lof\SalesRep\Model\ResourceModel\Customer\Grid;

/**
 * Class Collection
 *
 * @package Lof\SalesRep\Model\ResourceModel\Customer\Grid
 */
class Collection extends \Magento\Customer\Model\ResourceModel\Grid\Collection {

    /**
     * Render.
     */
    public function _renderFiltersBefore()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $authSession   = $objectManager->get('\Magento\Backend\Model\Auth\Session');
        $currentUser   = $authSession->getUser();
        $userId        = $currentUser->getId();
        $isSalesRep    = $currentUser->getIsSalesrep();
        if ($isSalesRep) {
            $connection  = $this->getConnection();
            $tableName   = $this->getTable('lof_salesrep_customer');
            $fields      = ['customer_id'];
            $sql         = $connection->select()
                                      ->from($tableName, $fields)
                                      ->where('user_id = ?', $userId);
            $result      = $connection->fetchAll($sql);
            $customerIds = [];
            foreach ($result as $key => $value) {
                $customerIds[] = $value['customer_id'];
            }
            $this->addFieldToFilter('entity_id', ['in' => $customerIds]);
        }
        parent::_renderFiltersBefore();
    }
}
