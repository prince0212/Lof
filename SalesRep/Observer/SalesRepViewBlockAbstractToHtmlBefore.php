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

namespace Lof\SalesRep\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class SalesRepViewBlockAbstractToHtmlBefore
 *
 * @package Lof\SalesRep\Observer
 */
class SalesRepViewBlockAbstractToHtmlBefore implements ObserverInterface {
    /**
     * [$permissionManagement description]
     *
     * @var [type]
     */
    protected $permissionManagement;

    /**
     * SalesRepViewBlockAbstractToHtmlBefore constructor.
     *
     * @param \Magento\Framework\View\LayoutInterface             $layout
     * @param \Lof\SalesRep\Model\Permission\PermissionManagement $permissionManagement
     */
    public function __construct(
        \Magento\Framework\View\LayoutInterface $layout,
        \Lof\SalesRep\Model\Permission\PermissionManagement $permissionManagement
    )
    {
        $this->layout               = $layout;
        $this->permissionManagement = $permissionManagement;
    }

    /**
     * @param EventObserver $observer
     * @return $this
     */
    public function execute(EventObserver $observer)
    {
        $block = $observer->getEvent()->getBlock();
        if ($block instanceof \Magento\User\Block\User\Edit\Tabs) {
            $block->addTab(
                'salesrep_info',
                [
                    'label'   => __('Sale Representative Info'),
                    'title'   => __('Sale Representative Info'),
                    'after'   => 'roles_section',
                    'content' => $this->layout->createBlock(
                        \Lof\SalesRep\Block\Adminhtml\Salesrep\Edit\Tab\Info::class,
                        'salesrep.info.grid'
                    )->toHtml(),
                ]
            );

        }

        if ($block instanceof \Magento\User\Block\User\Edit\Tabs && $this->permissionManagement->checkPermission('Lof_SalesRep::salesrep_permission')) {
            $block->addTab(
                'customer_section',
                [
                    'label'   => __('Assigned Customers'),
                    'title'   => __('Assigned Customers'),
                    'after'   => 'roles_section',
                    'content' => $this->layout->createBlock(
                        \Lof\SalesRep\Block\Adminhtml\Salesrep\Edit\Tab\Customer::class,
                        'salesrep.customer.grid'
                    )->toHtml(),
                ]
            );
        }

        if ($block instanceof \Magento\User\Block\User\Edit\Tabs && $this->permissionManagement->checkPermission('Lof_SalesRep::salesrep_permission')) {
            $block->addTab(
                'salesrep_reports',
                [
                    'label'   => __('Reports'),
                    'title'   => __('Reports'),
                    'after'   => 'roles_section',
                    'content' => $this->layout->createBlock(
                        \Lof\SalesRep\Block\Adminhtml\Salesrep\Edit\Tab\Reports::class,
                        'salesrep.reports.grid'
                    )->toHtml(),
                ]
            );
        }

        return $this;
    }
}
