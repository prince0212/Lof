<?php


namespace Lof\SalesRep\Api\Data;

/**
 * Interface MessageInterface
 * @package Lof\SalesRep\Api\Data
 */
interface MessageInterface
{

    /**
     *
     */
    const MESSAGE_ID = 'message_id';


    /**
     * Get message_id
     * @return string|null
     */
    public function getMessageId();

    /**
     * Set message_id
     * @param string $messageId
     * @return \Lof\SalesRep\Api\Data\MessageInterface
     */
    public function setMessageId($messageId);
}
