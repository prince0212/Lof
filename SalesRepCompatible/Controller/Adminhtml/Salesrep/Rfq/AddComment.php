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
 * @copyright  Copyright (c) 2020 Landofcoder (https://www.landofcoder.com/)
 * @license    https://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\SalesRepCompatible\Controller\Adminhtml\Salesrep\Rfq;

use Lof\SalesRepCompatible\Model\QuoteFactory;
use Lof\SalesRep\Helper\Data;
use Lof\SalesRep\Model\ResourceModel\CommentHistory\CollectionFactory;
use Lof\SalesRepCompatible\Model\QuoteCommentHistoryFactory;
use Magento\Backend\App\Action;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\Translate\InlineInterface;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Sales\Api\OrderManagementInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\InputException;
use Magento\User\Model\UserFactory;
use Psr\Log\LoggerInterface;

class AddComment extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Lof_SalesRep::comment';
    /**
     * @var CollectionFactory
     */
    protected $_commentHistoryFactory;

    /**
     * @var UserFactory
     */
    protected $_userFactory;

    /**
     * @var QuoteFactory
     */
    protected $_quoteFactory;
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var FileFactory
     */
    protected $_fileFactory;

    /**
     * @var InlineInterface
     */
    protected $_translateInline;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var LayoutFactory
     */
    protected $resultLayoutFactory;

    /**
     * @var RawFactory
     */
    protected $resultRawFactory;

    /**
     * @var OrderManagementInterface
     */
    protected $orderManagement;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    protected $_authSession;

    protected $_salesrepHelper;
    /**
     * Add order comment action
     *
     * @return ResultInterface
     */
    /**
     * @param Action\Context $context
     * @param Registry $coreRegistry
     * @param FileFactory $fileFactory
     * @param InlineInterface $translateInline
     * @param PageFactory $resultPageFactory
     * @param JsonFactory $resultJsonFactory
     * @param LayoutFactory $resultLayoutFactory
     * @param RawFactory $resultRawFactory
     * @param OrderManagementInterface $orderManagement
     * @param LoggerInterface $logger
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
     */
    public function __construct(
        Action\Context $context,
        Registry $coreRegistry,
        FileFactory $fileFactory,
        InlineInterface $translateInline,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory,
        LayoutFactory $resultLayoutFactory,
        RawFactory $resultRawFactory,
        QuoteCommentHistoryFactory $commentHistoryFactory,
        Data $salesrepHelper,
        UserFactory $userFactory,
        QuoteFactory $quoteFactory,
        Session $authSession,
        OrderManagementInterface $orderManagement,
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
        $this->_commentHistoryFactory    = $commentHistoryFactory;
        $this->_salesrepHelper  = $salesrepHelper;
        $this->_userFactory = $userFactory;
        $this->_quoteFactory    = $quoteFactory;
        $this->_authSession = $authSession;
        $this->logger = $logger;

        parent::__construct($context);
    }

    protected function _initQuote(){
        $id = $this->getRequest()->getParam('quote_id');
        $model = $this->_objectManager->create('Lof\SalesRepCompatible\Model\Quote');
        if($id){
            try {
                $quote = $model->load($id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addError(__('This quote no longer exists.'));
                $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
                return false;
            } catch (InputException $e) {
                $this->messageManager->addError(__('This quote no longer exists.'));
                $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
                return false;
            }
        }

        $this->_coreRegistry->register('current_quote', $quote);
        return $quote;

    }
    protected function getUserName( $userId ){
        $user = $this->_userFactory->create()->load($userId);
        return $user->getFirstName().' '.$user->getLastName();
    }

    /**
     * Add a comment to order
     * Different or default status may be specified
     *
     * @param string $comment
     * @param $salesrepId
     * @return OrderStatusHistoryInterface
     */
    public function addSalesRepHistoryComment( $comment, $salesrepId )
    {
        if( $salesrepId !== '0' ){
            $assignTo   = $this->getUserName($salesrepId);
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
    public function updateSalesrepForQuote($assignSalesrepId, $salesrepId )
    {
        $quote  = $this->getQuote()
                ->setAssignSalesrepId( (int)$assignSalesrepId )
                ->setSalesrepId( (int)$salesrepId );
        $quote->save();
    }

    public function getQuote(){
        $quoteId        = $this->getRequest()->getParam('quote_id');
        $quote          = $this->_quoteFactory->create()->load($quoteId);
        return $quote;
    }
    /**
     * Execute view action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $currentUser = $this->_authSession->getUser();
        $userId = $currentUser->getId();
        $userChangeName = $this->getUserName($userId);
        $quote = $this->_initQuote();
        if ($quote) {
            try {
                $data           = $this->getRequest()->getPost('history');
                $notify         = isset($data['is_customer_notified']) ? $data['is_customer_notified'] : false;
                $useForOder     = isset($data['use_for_order']) ? $data['use_for_order'] : false;
                $customerId     = $quote->getCustomerId();
                $quote          = $this->getQuote();

                $currentSalesrepId = (int)$quote->getSalesrepId();
                if(isset( $currentSalesrepId ) && $currentSalesrepId !== 0 ){
                    $assignFrom = $this->getUserName($currentSalesrepId);
                }else{
                    $currentSalesrepId  = 0;
                    $assignFrom = __('Admin');
                }
                $history = $this->addSalesRepHistoryComment($data['comment'], $data['salesrep_id']);
                $history->setUserChange($userChangeName);
                $history->setAssignFrom($assignFrom);
                $history->setQuoteId($quote->getId());
                $history->setUseForOrder($useForOder);
                $history->setIsCustomerNotified($notify);
                $history->save();

                $this->updateSalesrepForQuote($currentSalesrepId, $data['salesrep_id']);
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
                    $mailHelper->sendNotificationSalesrepComment($quote, $email, $bcc, $userName, $notify, $comment);
                }
                $response = ['error' => false, 'message' => __('We assigned sales rep to the quote.')];
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $response = ['error' => true, 'message' => $e->getMessage()];
            } catch (\Exception $e) {
                $response = ['error' => true, 'message' => __('We cannot assign sales rep user to quote and add quote history.')];
            }
            if (is_array($response)) {
                $resultJson = $this->resultJsonFactory->create();
                $resultJson->setData($response);
                return $resultJson;
            }
        }

        $response = ['error' => true, 'message' => __('We cannot assign sales rep user to quote and add quote history.')];
        $resultJson = $this->resultJsonFactory->create();
        $resultJson->setData($response);

       return $resultJson;
    }
}
