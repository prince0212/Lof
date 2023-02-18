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

namespace Lof\SalesRep\Block\Adminhtml\Salesrep\Edit\Tab\Customer\Grid\Renderer;

/**
 * Adminhtml newsletter queue grid block status item renderer
 */
class CustomerGroup extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * @var array
     */
    protected static $_groups;

    /**
     * Constructor for Grid Renderer Status
     *
     * @return void
     */
    protected function _construct()
    {
        $objectManager  = \Magento\Framework\App\ObjectManager::getInstance();
        $groupOptions   = $objectManager->get('\Magento\Customer\Model\ResourceModel\Group\Collection')->toOptionArray();
        foreach ($groupOptions as $key => $value) {
            $_groups[$value['value']] = $value['label'];
        }
        self::$_groups = $_groups;
        parent::_construct();
    }

    /**
     * @param \Magento\Framework\DataObject $row
     * @return \Magento\Framework\Phrase
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        return __($this->getGroupCustomer($row->getGroupId()));
    }

    /**
     * @param string $status
     * @return \Magento\Framework\Phrase
     */
    public static function getGroupCustomer($customerId)
    {
        if (isset(self::$_groups[$customerId])) {
            return self::$_groups[$customerId];
        }

        return __('Unknown');
    }
}
