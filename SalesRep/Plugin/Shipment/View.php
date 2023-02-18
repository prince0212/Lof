<?php

namespace Lof\SalesRep\Plugin\Shipment;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Sales\Api\ShipmentRepositoryInterface;

/**
 * Class View
 * @package Lof\SalesRep\Plugin\Order
 */
class View extends \Magento\Sales\Controller\Adminhtml\Shipment\AbstractShipment\View
{
    /**
     * @var ShipmentRepositoryInterface
     */
    private $shipmentRepository;
    /**
     * @var RedirectInterface
     */
    private $redirect;

    /**
     * View constructor.
     * @param Context $context
     * @param ForwardFactory $resultForwardFactory
     * @param ShipmentRepositoryInterface $shipmentRepository
     * @param RedirectInterface $redirect
     */
    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory,
        ShipmentRepositoryInterface $shipmentRepository,
        RedirectInterface $redirect
    )
    {
        $this->shipmentRepository = $shipmentRepository;
        $this->redirect = $redirect;
        parent::__construct($context, $resultForwardFactory);
    }

    /**
     * @param $subject
     * @param $procede
     * @param $request
     * @return mixed
     */
    public function aroundDispatch($subject, $procede, $request)
    {
        $id = $this->getRequest()->getParam('shipment_id');
        $shipment = $this->shipmentRepository->get($id);
        if ($shipment) {
            $objectManager = ObjectManager::getInstance();
            $authSession = $objectManager->get('\Magento\Backend\Model\Auth\Session');
            $currentUser = $authSession->getUser();
            $userId = $currentUser->getId();
            $isSalesRep = $currentUser->getIsSalesrep();
            $resultRedirect = $this->resultFactory->create(
                \Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT
            );
            if ($isSalesRep && $shipment->getSalesrepId() != $userId) {
                $this->messageManager->addErrorMessage(__('You don\'t have permission to view this shipment.'));
                $result = $resultRedirect->setPath('sales/shipment/index');
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
