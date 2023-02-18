<?php
namespace Lof\SalesRep\Controller\Adminhtml\Order;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;

/**
 * Class Index
 * @package Lof\SalesRep\Controller\Adminhtml\Order
 */
class Index extends \Magento\Sales\Controller\Adminhtml\Order implements HttpGetActionInterface
{
    /**
     * Orders grid
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('Orders'));
        return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Lof_SalesRep::order');
    }
}
