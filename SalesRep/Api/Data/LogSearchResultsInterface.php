<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\SalesRep\Api\Data;

/**
 * Interface LogSearchResultsInterface
 * @package Lof\SalesRep\Api\Data
 */
interface LogSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Log list.
     * @return \Lof\SalesRep\Api\Data\LogInterface[]
     */
    public function getItems();

    /**
     * Set order_id list.
     * @param \Lof\SalesRep\Api\Data\LogInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
