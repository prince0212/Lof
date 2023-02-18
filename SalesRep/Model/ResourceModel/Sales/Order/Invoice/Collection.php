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

namespace Lof\SalesRep\Model\ResourceModel\Sales\Order\Invoice;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\VersionControl\Snapshot;
use Magento\Sales\Model\ResourceModel\Order\Shipment;
use Psr\Log\LoggerInterface;

/**
 * Class Collection
 * @package Lof\SalesRep\Model\ResourceModel\Sales\Order\Invoice
 */
class Collection extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult
{

    /**
     * Collection constructor.
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param string $mainTable
     * @param string $resourceModel
     * @param null $identifierName
     * @param null $connectionName
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        $mainTable ='sales_invoice_grid',
        $resourceModel = \Magento\Sales\Model\ResourceModel\Order\Invoice::class,
        $identifierName = null,
        $connectionName = null
    )
    {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel, $identifierName, $connectionName);
    }

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
            $this->addFieldToFilter( 'salesrep_id', $userId  );
        }
        parent::_renderFiltersBefore();
	}
}
