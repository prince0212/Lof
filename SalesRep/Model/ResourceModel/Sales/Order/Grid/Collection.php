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

namespace Lof\SalesRep\Model\ResourceModel\Sales\Order\Grid;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Psr\Log\LoggerInterface as Logger;

/**
 * Class Collection
 * @package Lof\SalesRep\Model\ResourceModel\Sales\Order\Grid
 */
class Collection extends \Magento\Sales\Model\ResourceModel\Order\Grid\Collection
{
    /**
     *
     */
    public function _renderFiltersBefore()
	{
        $objectManager  = \Magento\Framework\App\ObjectManager::getInstance();
        $authSession   = $objectManager->get('\Magento\Backend\Model\Auth\Session');
        $currentUser = $authSession->getUser();
        $userId = $currentUser->getId();
        $isSalesRep = $currentUser->getIsSalesrep();
        if( $isSalesRep){
            $this->addFieldToFilter( 'main_table.salesrep_id', array( 'eq' => $userId ) );
        }
    }
}
