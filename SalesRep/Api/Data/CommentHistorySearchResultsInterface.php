<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\SalesRep\Api\Data;

/**
 * Interface CommentHistorySearchResultsInterface
 * @package Lof\SalesRep\Api\Data
 */
interface CommentHistorySearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get CommentHistory list.
     * @return \Lof\SalesRep\Api\Data\CommentHistoryInterface[]
     */
    public function getItems();

    /**
     * Set order_id list.
     * @param \Lof\SalesRep\Api\Data\CommentHistoryInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
