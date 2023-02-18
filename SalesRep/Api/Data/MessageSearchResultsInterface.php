<?php


namespace Lof\SalesRep\Api\Data;

/**
 * Interface MessageSearchResultsInterface
 * @package Lof\SalesRep\Api\Data
 */
interface MessageSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get Message list.
     * @return \Lof\SalesRep\Api\Data\MessageInterface[]
     */
    public function getItems();

    /**
     * Set message_id list.
     * @param \Lof\SalesRep\Api\Data\MessageInterface[] $items
     * @return $this
     */
    public function setItems( $items);
}
