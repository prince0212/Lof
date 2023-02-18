<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\SalesRep\Model\Data;

use Lof\SalesRep\Api\Data\CommentHistoryInterface;

/**
 * Class CommentHistory
 * @package Lof\SalesRep\Model\Data
 */
class CommentHistory extends \Magento\Framework\Api\AbstractExtensibleObject implements CommentHistoryInterface
{

    /**
     * Get commenthistory_id
     * @return string|null
     */
    public function getEntityId()
    {
        return $this->_get(self::COMMENTHISTORY_ID);
    }

    /**
     * Set commenthistory_id
     * @param string $commenthistoryId
     * @return \Lof\SalesRep\Api\Data\CommentHistoryInterface
     */
    public function setEntityId($commenthistoryId)
    {
        return $this->setData(self::COMMENTHISTORY_ID, $commenthistoryId);
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
     * @return \Lof\SalesRep\Api\Data\CommentHistoryInterface
     */
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * Get is_customer_notified
     * @return string|null
     */
    public function getIsCustomerNotified()
    {
        return $this->_get(self::IS_CUSTOMER_NOTIFIED);
    }

    /**
     * Set is_customer_notified
     * @param string $isCustomerNotified
     * @return \Lof\SalesRep\Api\Data\CommentHistoryInterface
     */
    public function setIsCustomerNotified($isCustomerNotified)
    {
        return $this->setData(self::IS_CUSTOMER_NOTIFIED, $isCustomerNotified);
    }

    /**
     * Get comment
     * @return string|null
     */
    public function getComment()
    {
        return $this->_get(self::COMMENT);
    }

    /**
     * Set comment
     * @param string $comment
     * @return \Lof\SalesRep\Api\Data\CommentHistoryInterface
     */
    public function setComment($comment)
    {
        return $this->setData(self::COMMENT, $comment);
    }

    /**
     * Get assign_from
     * @return string|null
     */
    public function getAssignFrom()
    {
        return $this->_get(self::ASSIGN_FROM);
    }

    /**
     * Set assign_from
     * @param string $assignFrom
     * @return \Lof\SalesRep\Api\Data\CommentHistoryInterface
     */
    public function setAssignFrom($assignFrom)
    {
        return $this->setData(self::ASSIGN_FROM, $assignFrom);
    }

    /**
     * Get assign_to
     * @return string|null
     */
    public function getAssignTo()
    {
        return $this->_get(self::ASSIGN_TO);
    }

    /**
     * Set assign_to
     * @param string $assignTo
     * @return \Lof\SalesRep\Api\Data\CommentHistoryInterface
     */
    public function setAssignTo($assignTo)
    {
        return $this->setData(self::ASSIGN_TO, $assignTo);
    }

    /**
     * Get user_change
     * @return string|null
     */
    public function getUserChange()
    {
        return $this->_get(self::USER_CHANGE);
    }

    /**
     * Set user_change
     * @param string $userChange
     * @return \Lof\SalesRep\Api\Data\CommentHistoryInterface
     */
    public function setUserChange($userChange)
    {
        return $this->setData(self::USER_CHANGE, $userChange);
    }

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->_get(self::CREATED_AT);
    }

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Lof\SalesRep\Api\Data\CommentHistoryInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}
