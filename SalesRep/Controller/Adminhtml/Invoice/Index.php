<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Lof\SalesRep\Controller\Adminhtml\Invoice;


/**
 * Class Index
 * @package Lof\SalesRep\Controller\Adminhtml\Invoice
 */
class Index extends \Magento\Sales\Controller\Adminhtml\Invoice\Index
{
    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Lof_SalesRep::invoice');
    }
}
