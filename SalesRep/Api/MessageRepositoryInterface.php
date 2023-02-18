<?php


namespace Lof\SalesRep\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface MessageRepositoryInterface
 * @package Lof\SalesRep\Api
 */
interface MessageRepositoryInterface
{


    /**
     * Save Message
     * @param \Lof\SalesRep\Api\Data\MessageInterface $message
     * @return \Lof\SalesRep\Api\Data\MessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Lof\SalesRep\Api\Data\MessageInterface $message
    );

    /**
     * Retrieve Message
     * @param string $messageId
     * @return \Lof\SalesRep\Api\Data\MessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($messageId);

    /**
     * Retrieve Message matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Lof\SalesRep\Api\Data\MessageSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Message
     * @param \Lof\SalesRep\Api\Data\MessageInterface $message
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Lof\SalesRep\Api\Data\MessageInterface $message
    );

    /**
     * Delete Message by ID
     * @param string $messageId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($messageId);
}
