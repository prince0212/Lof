<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\SalesRep\Api\Data;

/**
 * Interface CommentHistoryInterface
 * @package Lof\SalesRep\Api\Data
 */
interface CommentHistoryInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    /**
     *
     */
    const ORDER_ID = 'order_id';
    /**
     *
     */
    const CREATED_AT = 'created_at';
    /**
     *
     */
    const ASSIGN_TO = 'assign_to';
    /**
     *
     */
    const ASSIGN_FROM = 'assign_from';
    /**
     *
     */
    const USER_CHANGE = 'user_change';
    /**
     *
     */
    const COMMENTHISTORY_ID = 'commenthistory_id';
    /**
     *
     */
    const COMMENT = 'comment';
    /**
     *
     */
    const IS_CUSTOMER_NOTIFIED = 'is_customer_notified';

    /**
     * Get commenthistory_id
     * @return string|null
     */
    public function getEntityId();

    /**
     * Set commenthistory_id
     * @param string $entityId
     * @return CommentHistoryInterface
     */
    public function setEntityId($entityId);

    /**
     * Get order_id
     * @return string|null
     */
    public function getOrderId();

    /**
     * Set order_id
     * @param string $orderId
     * @return CommentHistoryInterface
     */
    public function setOrderId($orderId);

    /**
     * Get is_customer_notified
     * @return string|null
     */
    public function getIsCustomerNotified();

    /**
     * Set is_customer_notified
     * @param string $isCustomerNotified
     * @return CommentHistoryInterface
     */
    public function setIsCustomerNotified($isCustomerNotified);

    /**
     * Get comment
     * @return string|null
     */
    public function getComment();

    /**
     * Set comment
     * @param string $comment
     * @return CommentHistoryInterface
     */
    public function setComment($comment);

    /**
     * Get assign_from
     * @return string|null
     */
    public function getAssignFrom();

    /**
     * Set assign_from
     * @param string $assignFrom
     * @return CommentHistoryInterface
     */
    public function setAssignFrom($assignFrom);

    /**
     * Get assign_to
     * @return string|null
     */
    public function getAssignTo();

    /**
     * Set assign_to
     * @param string $assignTo
     * @return CommentHistoryInterface
     */
    public function setAssignTo($assignTo);

    /**
     * Get user_change
     * @return string|null
     */
    public function getUserChange();

    /**
     * Set user_change
     * @param string $userChange
     * @return CommentHistoryInterface
     */
    public function setUserChange($userChange);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return CommentHistoryInterface
     */
    public function setCreatedAt($createdAt);
}
