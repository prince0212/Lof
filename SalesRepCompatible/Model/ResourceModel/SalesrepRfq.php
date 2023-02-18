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

namespace Lof\SalesRep\Model\ResourceModel;

class SalesrepRfq extends AbstractResource
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('lof_salesrep_customer', 'salesrep_customer_id');
    }

    public function _deleteUserToCustomer( $userId )
    {
        $table = $this->getTable( 'lof_salesrep_customer' );
        $where = [ 'user_id = ?' => $userId ];
        $this->deleteData($table, $where);
    }

    public function _deleteCustomer( $customerId )
    {
        $table = $this->getTable( 'lof_salesrep_customer' );
        $where = [ 'customer_id = ?' => $customerId ];
        $this->deleteData($table, $where);
    }

 	/**
 	 * [_addUserToCustomer add salesrep to customer ]
 	 * @param [type] $customerId [description]
 	 * @param [type] $userId     [description]
 	 */
    public function _addUserToCustomer( $customerId, $userId )
    {
        if($this->_salesrepHelper->getConfig('email/send_email_when_salesrep_change')){
            $this->_mailHelper->sendNotificationSalesrepChange( $userId, $customerId );
        }
        $table = $this->getTable( 'lof_salesrep_customer' );
        $data = [
            'customer_id' => $customerId,
            'user_id' => $userId
        ];
        $this->insertData($table, $data);

    }

     /**
     * [_addSalesRepInfo add salesrep info ]
     * @param int $isSalesrep is sales rep user
     * @param string $description  description
     * @param int $userId  user id
     * @param string $bccEmail
     * @return void
     */
    public function _addSalesRepInfo( $isSalesrep = 0 , $description = "", $userId = 0, $bccEmail = "")
    {
        if (!$userId) {
            return;
        }
        $table = $this->getTable( 'admin_user' );
        $bind = [
            'is_salesrep' => $isSalesrep,
            'salesrep_info' => $description,
            'bcc_email' => $bccEmail
        ];
        $where = [ 'user_id =?' => $userId ];
        $this->updateData( $table, $bind, $where );
    }
}
