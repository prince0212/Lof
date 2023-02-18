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

namespace Lof\SalesRep\Model\ResourceModel\Sales\Order\Creditmemo;

use Magento\Framework\App\ObjectManager;

/**
 * Class Collection
 * @package Lof\SalesRep\Model\ResourceModel\Sales\Order\Creditmemo
 */
class Collection extends \Magento\Sales\Model\ResourceModel\Order\Creditmemo\Grid\Collection
{

    /**
     *
     */
    public function _renderFiltersBefore()
	{
        $objectManager  = ObjectManager::getInstance();
        $authSession   = $objectManager->get('\Magento\Backend\Model\Auth\Session');
        $currentUser = $authSession->getUser();
        $userId = $currentUser->getId();
		$isSalesRep = $currentUser->getIsSalesrep();

		if($isSalesRep){
			$this->addFieldToFilter( 'salesrep_id', $userId  );
		}
		parent::_renderFiltersBefore();
	}
}
