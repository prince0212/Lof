<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Lof\SalesRep\Controller\Adminhtml\Creditmemo;

/**
 * Class Index
 * @package Lof\SalesRep\Controller\Adminhtml\Creditmemo
 */
class Index extends \Magento\Sales\Controller\Adminhtml\Creditmemo\Index
{
    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Lof_SalesRep::creditmemo');
    }
}
