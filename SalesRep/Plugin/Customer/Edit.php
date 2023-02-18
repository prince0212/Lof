<?php

namespace Lof\SalesRep\Plugin\Customer;

use Magento\Framework\App\ObjectManager;

class Edit extends \Magento\Customer\Controller\Adminhtml\Index\Edit
{
    /**
     * @param $subject
     * @param $proceed
     * @param $request
     * @return \Magento\Framework\Controller\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function aroundDispatch($subject, $proceed, $request)
    {
        $id = $this->getRequest()->getParam('id');
        if (!$id) {
            return $proceed($request);
        }
        $customer = $this->_customerRepository->getById($id);
        if ($customer) {
            $objectManager = ObjectManager::getInstance();
            $authSession = $objectManager->get('\Magento\Backend\Model\Auth\Session');
            $currentUser = $authSession->getUser();
            $userId = $currentUser->getId();
            $isSalesRep = $currentUser->getIsSalesrep();
            $resultRedirect = $this->resultFactory->create(
                \Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT
            );

            $salerepCustomerModel = $objectManager->get('\Lof\SalesRep\Model\SalesrepCustomer');
            $customerSalesRep = $salerepCustomerModel->load($id, 'customer_id');
            if ($isSalesRep && $customerSalesRep->getUserId() != $userId) {
                $this->messageManager->addErrorMessage(__('You don\'t have permission to edit this customer.'));
                return $resultRedirect->setPath('customer/index/index');
            }
        }

        return $proceed($request);
    }
}
