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

namespace Lof\SalesRep\Controller\Adminhtml\Salesrep;

/**
 * Class CustomerGrid
 * @package Lof\SalesRep\Controller\Adminhtml\Salesrep
 */
class CustomerGrid extends \Magento\User\Controller\Adminhtml\User
{
    /**
     * @return void
     */
    public function execute()
    {
        $userId = $this->getRequest()->getParam('user_id');
        /** @var \Magento\User\Model\User $model */
        $model = $this->_userFactory->create();

        if ($userId) {
            $model->load($userId);
        }
        $this->_coreRegistry->register('permissions_user', $model);
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
