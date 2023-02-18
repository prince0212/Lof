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

namespace Lof\SalesRep\Model;

/**
 * Class SalesrepCustomer
 *
 * @package Lof\SalesRep\Model
 */
class SalesrepCustomer extends \Magento\Framework\Model\AbstractModel {
    /**
     * @var string
     */
    protected $_eventPrefix = 'lof_salesrep_customer';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Lof\SalesRep\Model\ResourceModel\SalesrepCustomer');
    }
}
