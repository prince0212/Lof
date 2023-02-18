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

namespace Lof\SalesRep\Model\ResourceModel;

/**
 * Class CommentHistory
 * @package Lof\SalesRep\Model\ResourceModel
 */
class CommentHistory extends AbstractResource
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init( 'lof_salesrep_order_comment_history', 'entity_id' );
    }

}
