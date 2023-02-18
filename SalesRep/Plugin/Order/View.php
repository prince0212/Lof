<?php
namespace Lof\SalesRep\Plugin\Order;

use Magento\Framework\App\ObjectManager;

/**
 * Class View
 * @package Lof\SalesRep\Plugin\Order
 */
class View extends \Magento\Sales\Controller\Adminhtml\Order\View
{
    /**
     * @param $subject
     * @param $procede
     * @param $request
     * @return mixed
     */
    public function aroundDispatch($subject, $procede, $request)
    {
        $id = $this->getRequest()->getParam('order_id');
        $order = $this->orderRepository->get($id);
        if ($order) {
            $objectManager = ObjectManager::getInstance();
            $authSession = $objectManager->get('\Magento\Backend\Model\Auth\Session');
            $currentUser = $authSession->getUser();
            $userId = $currentUser->getId();
            $isSalesRep = $currentUser->getIsSalesrep();
            $resultRedirect = $this->resultFactory->create(
                \Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT
            );
            if ($isSalesRep && $order->getSalesrepId() != $userId) {
                $this->messageManager->addErrorMessage(__('You don\'t have permission to view this order.'));
                $result = $resultRedirect->setPath('sales/order/index');
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
