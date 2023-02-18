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
 * @package    Lof_SalesRepCompatible
 * @copyright  Copyright (c) 2020 Landofcoder (https://www.landofcoder.com/)
 * @license    https://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\SalesRepCompatible\Model\ResourceModel;

use Lof\SalesRep\Model\ResourceModel\AbstractResource;

class QuoteCommentHistory extends AbstractResource
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init( 'lof_salesrep_quote_comment_history', 'entity_id' );
    }

}
