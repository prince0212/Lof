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

namespace Lof\SalesRep\Block\Adminhtml\SalesrepInfo\Renderer;

/**
 * Class SalesrepInfo
 *
 * @package Lof\SalesRep\Block\Adminhtml\SalesrepInfo\Renderer
 */
class SalesrepInfo extends \Magento\Framework\Data\Form\Element\AbstractElement {
    /**
     * @return string
     */
    public function getElementHtml()
    {
        $customDiv = '';
        if ($this->getValue()) {
            $customDiv = '<div style="margin:10px 0;border:1px solid #000; padding:10px;" id="salesrep_info">' . $this->getValue() . '</div>';
        }

        return $customDiv;
    }
}
