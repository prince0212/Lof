<?php

namespace Lof\SalesRepCompatible\Plugin\Quote;

use Lof\SalesRepCompatible\Model\Quote;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResponseInterface;
use Magento\Backend\Model\Auth\SessionFactory;

/**
 * Class View
 * @package Lof\SalesRepCompatible\Plugin\Quote
 */
class View extends Action
{

    /**
     * @var Quote
     */
    private $quote;

    /**
     * @var SessionFactory
     */
    protected $sessionFactory;

    /**
     * View constructor.
     * @param Context $context
     * @param Quote $quote
     * @param SessionFactory $sessionFactory
     */
    public function __construct(
        Context $context,
        Quote $quote,
        SessionFactory $sessionFactory
    )
    {
        parent::__construct($context);
        $this->quote = $quote;
        $this->sessionFactory = $sessionFactory;
    }

    /**
     * @param $subject
     * @param $procede
     * @param $request
     * @return mixed
     */
    public function aroundDispatch($subject, $procede, $request)
    {
        $id = $this->getRequest()->getParam('entity_id');
        $quote = $this->quote->load($id);
        $authSession = $this->sessionFactory->create();
        $flag = false;
        if ($quote && $currentUser = $authSession->getUser()) {
            $userId = $currentUser->getId();
            $isSalesRep = $currentUser->getIsSalesrep();
            $resultRedirect = $this->resultFactory->create(
                \Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT
            );
            if ($isSalesRep && $quote->getSalesrepId() != $userId) {
                $this->messageManager->addErrorMessage(__('You don\'t have permission to view this quote.'));
                $result = $resultRedirect->setPath('quotation/quote/index');
                $flag = true;
            }
        }
        if(!$flag){
            $result = $procede($request);
        }
        return $result;
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        // TODO: Implement execute() method.
    }
}
