<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\SalesRep\Api\Data;

/**
 * Interface LogInterface
 * @package Lof\SalesRep\Api\Data
 */
interface LogInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    /**
     *
     */
    const ORDER_ID = 'order_id';
    /**
     *
     */
    const USER_ID = 'user_id';
    /**
     *
     */
    const CONTENT = 'content';
    /**
     *
     */
    const LOG_ID = 'log_id';
    /**
     *
     */
    const CREATED = 'created';
    /**
     *
     */
    const MODIFIED = 'modified';

    /**
     * Get log_id
     * @return string|null
     */
    public function getLogId();

    /**
     * Set log_id
     * @param string $logId
     * @return \Lof\SalesRep\Api\Data\LogInterface
     */
    public function setLogId($logId);

    /**
     * Get order_id
     * @return string|null
     */
    public function getOrderId();

    /**
     * Set order_id
     * @param string $orderId
     * @return \Lof\SalesRep\Api\Data\LogInterface
     */
    public function setOrderId($orderId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\SalesRep\Api\Data\LogExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Lof\SalesRep\Api\Data\LogExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\SalesRep\Api\Data\LogExtensionInterface $extensionAttributes
    );

    /**
     * Get user_id
     * @return string|null
     */
    public function getUserId();

    /**
     * Set user_id
     * @param string $userId
     * @return \Lof\SalesRep\Api\Data\LogInterface
     */
    public function setUserId($userId);

    /**
     * Get content
     * @return string|null
     */
    public function getContent();

    /**
     * Set content
     * @param string $content
     * @return \Lof\SalesRep\Api\Data\LogInterface
     */
    public function setContent($content);

    /**
     * Get created
     * @return string|null
     */
    public function getCreated();

    /**
     * Set created
     * @param string $created
     * @return \Lof\SalesRep\Api\Data\LogInterface
     */
    public function setCreated($created);

    /**
     * Get modified
     * @return string|null
     */
    public function getModified();

    /**
     * Set modified
     * @param string $modified
     * @return \Lof\SalesRep\Api\Data\LogInterface
     */
    public function setModified($modified);
}
