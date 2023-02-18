<?php
namespace Lof\SalesRep\Plugin\Invoice;

use Magento\Framework\App\ObjectManager;

/**
 * Class View
 * @package Lof\SalesRep\Plugin\Invoice
 */
class View extends \Magento\Sales\Controller\Adminhtml\Invoice\View
{

    /**
     * @param $subject
     * @param $procede
     * @param $request
     * @return mixed
     */
    public function aroundDispatch($subject, $procede, $request)
    {
        $id = $this->getRequest()->getParam('invoice_id');
        $invoice = $this->invoiceRepository->get($id);
        if ($invoice) {
            $objectManager = ObjectManager::getInstance();
            $authSession = $objectManager->get('\Magento\Backend\Model\Auth\Session');
            $currentUser = $authSession->getUser();
            $userId = $currentUser->getId();
            $isSalesRep = $currentUser->getIsSalesrep();
            $resultRedirect = $this->resultFactory->create(
                \Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT
            );
            if ($isSalesRep && $invoice->getSalesrepId() != $userId) {
                $this->messageManager->addErrorMessage(__('You don\'t have permission to view this invoice.'));
                $result = $resultRedirect->setPath('sales/invoice/index');
            }
            else {
                $result = $procede($request);
            }
        }
        else {
            $result = $procede($request);
        }
        return $result;
    }
}
