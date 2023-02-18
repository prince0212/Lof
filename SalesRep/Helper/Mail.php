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
namespace Lof\SalesRep\Helper;

/**
 * Class Mail
 * @package Lof\SalesRep\Helper
 */
class Mail extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var
     */
    protected $_currency;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $timezone;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var Data
     */
    protected $_salesrepHelper;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $_customerFactory;

    /**
     * @var \Magento\User\Model\UserFactory
     */
    protected $_userFactory;


    /**
     * Mail constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     * @param \Magento\Framework\Url $urlBuilder
     * @param \Lof\SalesRep\Model\Mail\UploadTransportBuilder $transportBuilder
     * @param Data $salesrepHelper
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory
     * @param \Magento\User\Model\UserFactory $userFactory
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        \Magento\Framework\Url $urlBuilder,
        \Lof\SalesRep\Model\Mail\UploadTransportBuilder $transportBuilder,
        \Lof\SalesRep\Helper\Data $salesrepHelper,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\User\Model\UserFactory $userFactory
    ) {
        parent::__construct($context);
        $this->context           = $context;
        $this->inlineTranslation = $inlineTranslation;
        $this->dateTime          = $dateTime;
        $this->messageManager    = $messageManager;
        $this->transportBuilder  = $transportBuilder;
        $this->_storeManager     = $storeManager;
        $this->timezone          = $timezone;
        $this->_urlBuilder       = $urlBuilder;
        $this->_salesrepHelper   = $salesrepHelper;
        $this->_userFactory      = $userFactory;
        $this->_customerFactory   = $customerFactory;
        $this->logger            = $context->getLogger();
    }

    /**
     * @param $templateName
     * @param $senderName
     * @param $senderEmail
     * @param $recipientEmail
     * @param $recipientName
     * @param $variables
     * @param null $storeId
     * @param array $file
     * @param string $filetype
     * @return bool
     */
    public function send($templateName, $senderName, $senderEmail, $recipientEmail, $recipientName, $variables, $storeId = null, $file = [], $filetype="PDF")
    {
        $this->inlineTranslation->suspend();
        try {
            $attach_type = "";
            if($filetype == "PDF") {
                $attach_type = 'application/pdf';
            }
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $this->transportBuilder
            ->setTemplateIdentifier($templateName)
            ->setTemplateOptions([
                'area'  => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => $storeId,
                ])
            ->setTemplateVars($variables)
            ->setFrom([
                'name'  => $senderName,
                'email' => $senderEmail
                ])
            ->addTo($recipientEmail, $recipientName)
            ->setReplyTo($senderEmail);

            if($file && $attach_type) {
                $file_content = isset($file['output'])?$file['output']:'';
                $file_name = isset($file['filename'])?$file['filename']:'';
                $this->transportBuilder->addAttachment($file_content, $file_name, $attach_type);
            }
            $transport = $this->transportBuilder->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addError(__('We can\'t send the email quote right now.'));
            $this->logger->critical($e);
        }

        $this->inlineTranslation->resume();
        return true;
    }

    /**
     * Get formatted order created date in store timezone
     *
     * @param   string $format date format type (short|medium|long|full)
     * @return  string
     */
    public function getCreatedAtFormatted($time, $store, $format)
    {
        return $this->timezone->formatDateTime(
            new \DateTime($time),
            $format,
            $format,
            null,
            $this->timezone->getConfigTimezone('store', $store)
            );
    }

    /**
     * @param $quote
     * @return string
     */
    protected function getCustomerName($quote)
    {
        if ($quote->getFirstName()) {
            $customerName = $quote->getFirstName() . ' ' . $quote->getLastName();
        } else {
            $customerName = (string)__('Guest');
        }
        return $customerName;
    }

    /**
     * @param $quote
     * @param $email
     * @param $bcc
     * @param $userName
     * @param bool $notify
     * @param string $comment
     * @param array $file
     * @param string $file_type
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function sendNotificationSalesrepComment($quote, $email, $bcc, $userName, $notify = true, $comment = '', $file = [], $file_type = "PDF")
    {
        $templateName = $this->_salesrepHelper->getConfig('email/assign_dealer');
        $storeScope   = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $senderId     = $this->_salesrepHelper->getConfig('email/sender_email_identity');

        if ($senderId) {
            $recipientEmail = $email;
            $storeId     = $this->_storeManager->getStore()->getId();
            $recipientName  = '';
            $customerName   = $this->getCustomerName($quote);
            $variables      = [
                'increment_id' => $quote->getIncrementId(),
                'created_at'   => $this->getCreatedAtFormatted($quote->getCreatedAt(), $storeId, \IntlDateFormatter::MEDIUM),
                'quote'        => $quote,
                'comment'     => $comment,
                'user_name' => $userName
            ];

            $senderName  = $this->context->getScopeConfig()->getValue("trans_email/ident_" . $senderId . "/name");
            $senderEmail = $this->context->getScopeConfig()->getValue("trans_email/ident_" . $senderId . "/email");

            $this->send($templateName, $senderName, $senderEmail, $recipientEmail, $recipientName, $variables, $storeId, $file, $file_type);

            if ($bcc && $bcc !== '') {
                $bcc = explode(",", $bcc);
                foreach ($bcc as $bccEmail) {
                    $bccEmail = trim($bccEmail);
                    $this->send($templateName, $senderName, $senderEmail, $bccEmail, $recipientName, $variables, $storeId);
                }
            }
            return true;
        }
        return false;
    }

    /**
     * @param $userId
     * @param $customerId
     * @param array $file
     * @param string $file_type
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function sendNotificationSalesrepChange($userId, $customerId, $file = [], $file_type = "PDF" )
    {
        $templateName = $this->_salesrepHelper->getConfig('email/update_dealer');
        $storeScope   = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $senderId     = $this->_salesrepHelper->getConfig('email/sender_email_identity');
        $user         = $this->_userFactory->create()->load($userId);
        $customer     = $this->_customerFactory->create()->load($customerId);

        if ($senderId) {
            $recipientEmail = $customer->getEmail();
            $storeId     = $this->_storeManager->getStore()->getId();
            $recipientName  = '';
            $customerName   = $customer->getCustomerName();
            $variables      = [
                'user'          => $user,
                'customer'      => $customer
            ];

            $senderName  = $this->context->getScopeConfig()->getValue("trans_email/ident_" . $senderId . "/name");
            $senderEmail = $this->context->getScopeConfig()->getValue("trans_email/ident_" . $senderId . "/email");

            $this->send($templateName, $senderName, $senderEmail, $recipientEmail, $recipientName, $variables, $storeId, $file, $file_type);

            // $bcc = $this->_salesrepHelper->getConfig('email/bcc');
            // if ($bcc) {
            //     $bcc = explode(",", $bcc);
            //     foreach ($bcc as $email) {
            //         $email = trim($email);
            //         $this->send($templateName, $senderName, $senderEmail, $email, $recipientName, $variables, $storeId);
            //     }
            // }
            return true;
        }
        return false;
    }

}
