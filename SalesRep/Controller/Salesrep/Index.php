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

namespace Lof\SalesRep\Controller\Salesrep;

use Magento\Framework\Controller\ResultFactory;
use Magento\Review\Controller\Customer as CustomerController;

/**
 * Class Index
 * @package Lof\SalesRep\Controller\Salesrep
 */
class Index extends CustomerController
{
    /**
     * Render my product reviews
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        if ($navigationBlock = $resultPage->getLayout()->getBlock('customer_account_navigation')) {
            $navigationBlock->setActive('lof_salesrep/salesrep');
        }

        if ($block = $resultPage->getLayout()->getBlock('salesrep_index')) {
            $block->setRefererUrl($this->_redirect->getRefererUrl());
        }
        $resultPage->getConfig()->getTitle()->set(__('Sales Representative'));
        return $resultPage;
    }
}
