<?php
namespace Lof\SalesRep\Controller\Adminhtml\SalesRep;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class ExportSalesCsv
 * @package Lof\SalesRep\Controller\Adminhtml\SalesRep
 */
class ExportSalesCsv extends \Magento\Reports\Controller\Adminhtml\Report\Sales
{
    /**
     * Export sales report grid to CSV format
     *
     * @return ResponseInterface
     */
    public function execute()
    {
        $fileName = 'sales.csv';
        $grid = $this->_view->getLayout()->createBlock(\Magento\Reports\Block\Adminhtml\Sales\Sales\Grid::class);
        $this->_initReportAction($grid);
        return $this->_fileFactory->create($fileName, $grid->getCsvFile(), DirectoryList::VAR_DIR);
    }
}
