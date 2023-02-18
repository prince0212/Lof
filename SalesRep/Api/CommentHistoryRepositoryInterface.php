<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\SalesRep\Api;

use Lof\SalesRep\Api\Data\CommentHistoryInterface;
use Lof\SalesRep\Api\Data\CommentHistorySearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface CommentHistoryRepositoryInterface
 * @package Lof\SalesRep\Api
 */
interface CommentHistoryRepositoryInterface
{

    /**
     * Save CommentHistory
     * @param CommentHistoryInterface $commentHistory
     * @return CommentHistoryInterface
     * @throws LocalizedException
     */
    public function save(
        CommentHistoryInterface $commentHistory
    );

    /**
     * Retrieve CommentHistory
     * @param string $commenthistoryId
     * @return CommentHistoryInterface
     * @throws LocalizedException
     */
    public function get($commenthistoryId);

    /**
     * Retrieve CommentHistory matching the specified criteria.
     * @param SearchCriteriaInterface $searchCriteria
     * @return CommentHistorySearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete CommentHistory
     * @param CommentHistoryInterface $commentHistory
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(
        CommentHistoryInterface $commentHistory
    );

    /**
     * Delete CommentHistory by ID
     * @param string $commenthistoryId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($commenthistoryId);
}
