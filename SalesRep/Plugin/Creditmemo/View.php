<?php
namespace Lof\SalesRep\Plugin\Creditmemo;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Sales\Api\CreditmemoRepositoryInterface;

/**
 * Class View
 * @package Lof\SalesRep\Plugin\Creditmemo
 */
class View extends \Magento\Sales\Controller\Adminhtml\Creditmemo\View
{
    /**
     * @var CreditmemoRepositoryInterface
     */
    private $creditmemo;

    /**
     * View constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param CreditmemoRepositoryInterface $creditmemoRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        CreditmemoRepositoryInterface $creditmemoRepository
    )
    {
        $this->creditmemo = $creditmemoRepository;
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
        $id = $this->getRequest()->getParam('creditmemo_id');
        $creditmemo = $this->creditmemo->get($id);
        if ($creditmemo) {
            $objectManager = ObjectManager::getInstance();
            $authSession = $objectManager->get('\Magento\Backend\Model\Auth\Session');
            $currentUser = $authSession->getUser();
            $userId = $currentUser->getId();
            $isSalesRep = $currentUser->getIsSalesrep();
            $resultRedirect = $this->resultFactory->create(
                \Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT
            );
            if ($isSalesRep && $creditmemo->getSalesrepId() != $userId) {
                $this->messageManager->addErrorMessage(__('You don\'t have permission to view this creditmemo.'));
                $result = $resultRedirect->setPath('sales/creditmemo/index');
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
