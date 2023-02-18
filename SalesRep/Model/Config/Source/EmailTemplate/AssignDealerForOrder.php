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

namespace Lof\SalesRep\Model\Config\Source\EmailTemplate;

/**
 * Class AssignDealerForOrder
 * @package Lof\SalesRep\Model\Config\Source\EmailTemplate
 */
class AssignDealerForOrder implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @param \Magento\Email\Model\ResourceModel\Template\CollectionFactory $templatesFactory
     * @param \Magento\Email\Model\Template\Config                          $emailConfig
     */
    public function  __construct(
        \Magento\Email\Model\ResourceModel\Template\CollectionFactory $templatesFactory,
        \Magento\Email\Model\Template\Config $emailConfig
        ) {
        $this->_templatesFactory = $templatesFactory;
         $this->_emailConfig = $emailConfig;
    }
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $collection = $this->_templatesFactory->create();
        $collection->load();
        $options = $collection->toOptionArray();
        $templateId = 'assign_dealer_order';
        $templateLabel = $this->_emailConfig->getTemplateLabel($templateId);
        $templateLabel = __('%1 (Default)', $templateLabel);
        array_unshift($options, ['value' => $templateId, 'label' => $templateLabel]);
        $emailTemplates = [];
        foreach ($options as $k => $v) {
            $emailTemplates[$v['value']] = $v['label'];
        }
        return $emailTemplates;
    }
}
