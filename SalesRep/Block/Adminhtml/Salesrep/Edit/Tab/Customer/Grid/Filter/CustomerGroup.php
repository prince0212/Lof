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

namespace Lof\SalesRep\Block\Adminhtml\Salesrep\Edit\Tab\Customer\Grid\Filter;


use Magento\Newsletter\Model\Queue;

/**
 * Adminhtml newsletter subscribers grid website filter
 */
class CustomerGroup extends \Magento\Backend\Block\Widget\Grid\Column\Filter\Select
{
    /**
     * @return array
     */
    protected function _getOptions()
    {
        $objectManager  = \Magento\Framework\App\ObjectManager::getInstance();
        $groupOptions   = $objectManager->get('\Magento\Customer\Model\ResourceModel\Group\Collection')->toOptionArray();
        $options        = [];
        $options[]      = ['value' => '', 'label' => ''];
        foreach ($groupOptions as $key => $value) {
            $options[]  =  $value;
        }
        return $options;
    }

    /**
     * @return array|null
     */
    public function getCondition()
    {
        return $this->getValue() === null ? null : ['eq' => $this->getValue()];
    }
}
