<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\SalesRep\Model\Data;

use Lof\SalesRep\Api\Data\LogInterface;

/**
 * Class Log
 * @package Lof\SalesRep\Model\Data
 */
class Log extends \Magento\Framework\Api\AbstractExtensibleObject implements LogInterface
{

    /**
     * Get log_id
     * @return string|null
     */
    public function getLogId()
    {
        return $this->_get(self::LOG_ID);
    }

    /**
     * Set log_id
     * @param string $logId
     * @return \Lof\SalesRep\Api\Data\LogInterface
     */
    public function setLogId($logId)
    {
        return $this->setData(self::LOG_ID, $logId);
    }

    /**
     * Get order_id
     * @return string|null
     */
    public function getOrderId()
    {
        return $this->_get(self::ORDER_ID);
    }

    /**
     * Set order_id
     * @param string $orderId
     * @return \Lof\SalesRep\Api\Data\LogInterface
     */
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\SalesRep\Api\Data\LogExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Lof\SalesRep\Api\Data\LogExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\SalesRep\Api\Data\LogExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get user_id
     * @return string|null
     */
    public function getUserId()
    {
        return $this->_get(self::USER_ID);
    }

    /**
     * Set user_id
     * @param string $userId
     * @return \Lof\SalesRep\Api\Data\LogInterface
     */
    public function setUserId($userId)
    {
        return $this->setData(self::USER_ID, $userId);
    }

    /**
     * Get content
     * @return string|null
     */
    public function getContent()
    {
        return $this->_get(self::CONTENT);
    }

    /**
     * Set content
     * @param string $content
     * @return \Lof\SalesRep\Api\Data\LogInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Get created
     * @return string|null
     */
    public function getCreated()
    {
        return $this->_get(self::CREATED);
    }

    /**
     * Set created
     * @param string $created
     * @return \Lof\SalesRep\Api\Data\LogInterface
     */
    public function setCreated($created)
    {
        return $this->setData(self::CREATED, $created);
    }

    /**
     * Get modified
     * @return string|null
     */
    public function getModified()
    {
        return $this->_get(self::MODIFIED);
    }

    /**
     * Set modified
     * @param string $modified
     * @return \Lof\SalesRep\Api\Data\LogInterface
     */
    public function setModified($modified)
    {
        return $this->setData(self::MODIFIED, $modified);
    }
}
