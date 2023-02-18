<?php
namespace Lof\SalesRep\Controller\Adminhtml\SalesRep;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class ExportSalesExcel
 * @package Lof\SalesRep\Controller\Adminhtml\SalesRep
 */
class ExportSalesExcel extends \Magento\Reports\Controller\Adminhtml\Report\Sales
{
    /**
     * Export sales report grid to Excel XML format
     *
     * @return ResponseInterface
     */
    public function execute()
    {
        $fileName = 'sales.xml';
        $grid = $this->_view->getLayout()->createBlock(\Magento\Reports\Block\Adminhtml\Sales\Sales\Grid::class);
        $this->_initReportAction($grid);
        return $this->_fileFactory->create($fileName, $grid->getExcelFile($fileName), DirectoryList::VAR_DIR);
    }
}
