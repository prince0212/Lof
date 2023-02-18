<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Lof\SalesRep\Controller\Adminhtml\Salesrep\Report;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class ExportOrderExcel
 * @package Lof\SalesRep\Controller\Adminhtml\Salesrep\Report
 */
class ExportOrderExcel extends \Magento\Reports\Controller\Adminhtml\Report\Sales
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Lof_SalesRep::report';
    /**
     * Export bestsellers report grid to Excel XML format
     *
     * @return ResponseInterface
     */
    public function execute()
    {
        $fileName = 'orders.xml';
        $grid = $this->_view->getLayout()->createBlock(\Lof\SalesRep\Block\Adminhtml\Salesrep\Edit\Tab\Reports::class);
        $this->_initReportAction($grid);
        return $this->_fileFactory->create($fileName, $grid->getExcelFile($fileName), DirectoryList::VAR_DIR);
    }
}
