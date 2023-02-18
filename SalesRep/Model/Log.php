<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\SalesRep\Model;

use Lof\SalesRep\Api\Data\LogInterface;
use Lof\SalesRep\Api\Data\LogInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

/**
 * Class Log
 * @package Lof\SalesRep\Model
 */
class Log extends \Magento\Framework\Model\AbstractModel
{

    /**
     * @var string
     */
    protected $_eventPrefix = 'lof_salesrep_log';
    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var LogInterfaceFactory
     */
    protected $logDataFactory;


    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param LogInterfaceFactory $logDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Lof\SalesRep\Model\ResourceModel\Log $resource
     * @param \Lof\SalesRep\Model\ResourceModel\Log\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        LogInterfaceFactory $logDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Lof\SalesRep\Model\ResourceModel\Log $resource,
        \Lof\SalesRep\Model\ResourceModel\Log\Collection $resourceCollection,
        array $data = []
    ) {
        $this->logDataFactory = $logDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve log model with log data
     * @return LogInterface
     */
    public function getDataModel()
    {
        $logData = $this->getData();

        $logDataObject = $this->logDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $logDataObject,
            $logData,
            LogInterface::class
        );

        return $logDataObject;
    }
}
