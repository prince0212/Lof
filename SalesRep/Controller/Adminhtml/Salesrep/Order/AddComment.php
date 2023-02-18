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

namespace Lof\SalesRep\Controller\Adminhtml\Salesrep\Order;

use Magento\Backend\App\Action;
use Magento\Sales\Model\Order\Email\Sender\OrderCommentSender;
use Magento\Sales\Api\OrderManagementInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\InputException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * Class AddComment
 * @package Lof\SalesRep\Controller\Adminhtml\Salesrep\Order
 */
class AddComment extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Lof_SalesRep::comment';
    /**
     * @var \Lof\SalesRep\Model\ResourceModel\CommentHistory\CollectionFactory
     */
    protected $_commentHistoryFactory;

    /**
     * @var \Magento\User\Model\UserFactory
     */
    protected $_userFactory;
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $_fileFactory;

    /**
     * @var \Magento\Framework\Translate\InlineInterface
     */
    protected $_translateInline;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $resultLayoutFactory;

    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;

    /**
     * @var OrderManagementInterface
     */
    protected $orderManagement;

    /**
     * @var OrderRepositoryInterface
     */
    protected $_orderRepository;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     *  @var \Magento\Backend\Model\Auth\Session
     */
    protected $_authSession;

    /**
     * @var \Lof\SalesRep\Helper\Data
     */
    protected $_salesrepHelper;

    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $_orderFactory;
    /**
     * Add order comment action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    /**
     * @param Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param \Magento\Framework\Translate\InlineInterface $translateInline
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     * @param OrderManagementInterface $orderManagement
     * @param OrderRepositoryInterface $orderRepository
     * @param LoggerInterface $logger
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Translate\InlineInterface $translateInline,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Lof\SalesRep\Model\CommentHistoryFactory $commentHistoryFactory,
        \Lof\SalesRep\Helper\Data $salesrepHelper,
        \Magento\User\Model\UserFactory $userFactory,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        OrderManagementInterface $orderManagement,
        OrderRepositoryInterface $orderRepository,
        LoggerInterface $logger
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_fileFactory = $fileFactory;
        $this->_translateInline = $translateInline;
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultLayoutFactory = $resultLayoutFactory;
        $this->resultRawFactory = $resultRawFactory;
        $this->orderManagement = $orderManagement;
        $this->_orderRepository = $orderRepository;
        $this->_commentHistoryFactory    = $commentHistoryFactory;
        $this->_orderFactory    = $orderFactory;
        $this->_salesrepHelper  = $salesrepHelper;
        $this->_userFactory = $userFactory;
        $this->_authSession = $authSession;
        $this->logger = $logger;

        parent::__construct($context);
    }

    /**
     * Initialize order model instance
     *
     * @return \Magento\Sales\Api\Data\OrderInterface|false
     */
    protected function _initOrder()
    {
        $id = $this->getRequest()->getParam('order_id');
        try {
            $order = $this->_orderRepository->get($id);
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('This order no longer exists.'));
            $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
            return false;
        } catch (InputException $e) {
            $this->messageManager->addErrorMessage(__('This order no longer exists.'));
            $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
            return false;
        }
        $this->_coreRegistry->register('sales_order', $order);
        $this->_coreRegistry->register('current_order', $order);
        return $order;
    }

    /**
     * @param $userId
     * @return string
     */
    protected function getUserName($userId ){
        $user = $this->_userFactory->create()->load( $userId );
        return $user->getFirstName().' '.$user->getLastName();
    }
    /**
     * Add a comment to order
     * Different or default status may be specified
     *
     * @param string $comment
     * @param bool|string $status
     * @return OrderStatusHistoryInterface
     */
    public function addSalesRepHistoryComment( $comment, $salesrepId )
    {
        if( $salesrepId !== '0' ){
            $assignTo   = $this->getUserName( $salesrepId );
        }else{
            $assignTo   = __( 'Admin' );
        }
        $history = $this->_commentHistoryFactory->create()->setAssignTo(
            $assignTo
        )->setComment(
            $comment
        );

        return $history;
    }

        /**
     * Add a comment to order
     * Different or default status may be specified
     *
     * @param string $comment
     * @param bool|string $status
     * @return OrderStatusHistoryInterface
     */
    public function updateSalesrepForOrder( $assignSalesrepId, $salesrepId )
    {
        $newOrder  = $this->getOrder()
                ->setAssignSalesrepId( (int)$assignSalesrepId )
                ->setSalesrepId( (int)$salesrepId );

        // $this->_orderRepository->save($newOrder);
        $newOrder->save();

    }

    /**
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder(){
        $orderId = $this->getRequest()->getParam('order_id');
        // $order = $this->_orderRepository->get($orderId); // Get order by id
        $order = $this->_orderFactory->create()->load($orderId);
        return $order;
    }
    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $currentUser = $this->_authSession->getUser();
        $userId = $currentUser->getId();
        $userChangeName = $this->getUserName($userId);
        $order = $this->_initOrder();
        if ($order) {
            try {
                $data           = $this->getRequest()->getPost('history');
                $notify         = isset($data['is_customer_notified']) ? $data['is_customer_notified'] : false;
                $customerId     = $order->getCustomerId();
                $currentSalesrepId = (int)$order->getSalesrepId();
                if(isset( $currentSalesrepId ) && $currentSalesrepId !== 0 ){
                    $assignFrom = $this->getUserName($currentSalesrepId);
                }else{
                    $currentSalesrepId  = 0;
                    $assignFrom = __('Admin');
                }
                $this->updateSalesrepForOrder($currentSalesrepId, $data['salesrep_id']);
                $history = $this->addSalesRepHistoryComment($data['comment'], $data['salesrep_id']);
                $history->setUserChange($userChangeName);
                $history->setAssignFrom($assignFrom);
                $history->setOrderId($order->getId());
                $history->setUseForOrder(true);
                $history->setIsCustomerNotified($notify);
                $history->save();


                if(isset($data['is_customer_notified']) && (int)$data['is_customer_notified'] !== 0){
                    if( (int)$data['salesrep_id'] !== 0 ){
                        $user = $this->_userFactory->create()->load($data['salesrep_id']);
                        $email = $user->getEmail();
                        $userName = $this->getUserName($data['salesrep_id']);
                        $bcc = $user->getBccEmail();
                    }else{
                        $email = $this->_salesrepHelper->getConfig('email/admin_email');
                        $userName = $this->_salesrepHelper->getConfig('email/admin_name');
                        $bcc = '';
                    }

                    $comment = trim(strip_tags($data['comment']));
                    $mailHelper = $this->_objectManager
                        ->create(\Lof\SalesRep\Helper\Mail::class);
                    $mailHelper->sendNotificationSalesrepComment($order, $email, $bcc, $userName, $notify, $comment);
                }

                return $this->resultPageFactory->create();
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $response = ['error' => true, 'message' => $e->getMessage()];
            } catch (\Exception $e) {
                $response = ['error' => true, 'message' => __('We cannot add order history.')];
            }
            if (is_array($response)) {
                $resultJson = $this->resultJsonFactory->create();
                $resultJson->setData($response);
                return $resultJson;
            }
        }

        return $this->resultRedirectFactory->create()->setPath('dashboard');
    }
}
