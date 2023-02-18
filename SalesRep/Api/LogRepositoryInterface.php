<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\SalesRep\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface LogRepositoryInterface
 * @package Lof\SalesRep\Api
 */
interface LogRepositoryInterface
{

    /**
     * Save Log
     * @param \Lof\SalesRep\Api\Data\LogInterface $log
     * @return \Lof\SalesRep\Api\Data\LogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Lof\SalesRep\Api\Data\LogInterface $log
    );

    /**
     * Retrieve Log
     * @param string $logId
     * @return \Lof\SalesRep\Api\Data\LogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($logId);

    /**
     * Retrieve Log matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Lof\SalesRep\Api\Data\LogSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Log
     * @param \Lof\SalesRep\Api\Data\LogInterface $log
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Lof\SalesRep\Api\Data\LogInterface $log
    );

    /**
     * Delete Log by ID
     * @param string $logId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($logId);
}
