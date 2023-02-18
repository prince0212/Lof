<?php
namespace Lof\SalesRep\Controller\Adminhtml\Salesrep;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Helper\Data as BackendHelper;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Sales
 * @package Lof\SalesRep\Controller\Adminhtml\Salesrep\Dashboard
 */
class Sales extends \Magento\Reports\Controller\Adminhtml\Report\Sales implements HttpGetActionInterface
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;


    /**
     * Dashboard constructor.
     * @param Context $context
     * @param FileFactory $fileFactory
     * @param Date $dateFilter
     * @param TimezoneInterface $timezone
     * @param BackendHelper|null $backendHelperData
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        FileFactory $fileFactory,
        Date $dateFilter,
        TimezoneInterface $timezone,
        BackendHelper $backendHelperData = null,
        PageFactory $resultPageFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $fileFactory, $dateFilter, $timezone, $backendHelperData);
    }

    /**
     * Check the permission to run it
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Lof_SalesRep::dashboard');
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magento_Sales::sales');
        $resultPage->addBreadcrumb(__('SalesRep Dashboard'), __('SalesRep Dashboard'));
        $resultPage->addBreadcrumb(__('SalesRep Dashboard'), __('SalesRep Dashboard'));
        $resultPage->getConfig()->getTitle()->prepend(__('SalesRep Dashboard'));
        $gridBlock = $this->_view->getLayout()->getBlock('adminhtml_sales_sales.grid');
        $salesrepBlock = $this->_view->getLayout()->getBlock('salesrep_dashboard_chart');
        $filterFormBlock = $this->_view->getLayout()->getBlock('grid.filter.form');
        $this->_initReportAction([$gridBlock, $filterFormBlock, $salesrepBlock]);
        $this->_view->renderLayout();
    }

}
