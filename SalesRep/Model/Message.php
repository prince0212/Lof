<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_SalesRep
 * @copyright  Copyright (c) 2021 Landofcoder (https://www.landofcoder.com/)
 * @license    https://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\SalesRep\Model;

use Lof\SalesRep\Api\Data\MessageInterface;

/**
 * Class Message
 * @package Lof\SalesRep\Model
 */
class Message extends \Magento\Framework\Model\AbstractModel implements MessageInterface
{

    /**
     * @var string
     */
    protected $_eventPrefix = 'lof_salesrep_message';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Lof\SalesRep\Model\ResourceModel\Message');
    }

    /**
     * Get message_id
     * @return string
     */
    public function getMessageId()
    {
        return $this->getData(self::MESSAGE_ID);
    }

    /**
     * Set message_id
     * @param string $messageId
     * @return \Lof\SalesRep\Api\Data\MessageInterface
     */
    public function setMessageId($messageId)
    {
        return $this->setData(self::MESSAGE_ID, $messageId);
    }
}
