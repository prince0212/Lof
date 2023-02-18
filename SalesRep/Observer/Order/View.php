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

namespace Lof\SalesRep\Observer\Order;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Class View
 * @package Lof\SalesRep\Observer\Order
 */
class View implements ObserverInterface
{

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;
    /**
     * @var ResultFactory
     */
    private $resultFactory;
    /**
     * @var ManagerInterface
     */
    private $_messageManager;
    /**
     * @var UrlInterface
     */
    private $url;
    /**
     * @var Session
     */
    private $session;

    /**
     * View constructor.
     * @param UrlInterface $url
     * @param ManagerInterface $messageManager
     * @param OrderRepositoryInterface $orderRepository
     * @param Session $session
     */
    public function __construct(
        UrlInterface $url,
        ManagerInterface $messageManager,
        OrderRepositoryInterface $orderRepository,
        Session $session
    )
    {
        $this->session = $session;
        $this->url = $url;
        $this->_messageManager = $messageManager;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param EventObserver $observer
     * @return
     */
    public function execute(EventObserver $observer)
    {
        $controller = $observer->getControllerAction();
        $orderId = $controller->getRequest()->getParam('order_id');
        $order = $this->orderRepository->get($orderId);
        if ($order) {
            $currentUser = $this->session->getUser();
            $userId = $currentUser->getId();
            $isSalesRep = $currentUser->getIsSalesrep();
            if( $isSalesRep == 1 ){
                if($order->getSalesrepId() != $userId) {
                    $this->_messageManager->addErrorMessage(__('You don\'t have permission to view this order.'));
                    $controller->getResponse()->setRedirect($this->url->getUrl("sales/order/index"));
                    return $this;
                }
            }
        }
    }
}
