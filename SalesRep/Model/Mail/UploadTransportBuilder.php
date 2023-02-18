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

namespace Lof\SalesRep\Model\Mail;

use Magento\Framework\Mail\MessageInterface;
use Magento\Framework\Mail\TransportInterfaceFactory;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Mail\Template\FactoryInterface;
use Magento\Framework\Mail\Template\SenderResolverInterface;
use Magento\Framework\Mail\Template\TransportBuilder;


/**
 * Class UploadTransportBuilder
 * @package Lof\SalesRep\Model\Mail
 */
class UploadTransportBuilder extends TransportBuilder {
    /**
     * UploadTransportBuilder constructor.
     * @param FactoryInterface $templateFactory
     * @param MessageInterface $message
     * @param SenderResolverInterface $senderResolver
     * @param ObjectManagerInterface $objectManager
     * @param TransportInterfaceFactory $mailTransportFactory
     */
    public function __construct(FactoryInterface $templateFactory,
                                MessageInterface $message,
                                SenderResolverInterface $senderResolver,
                                ObjectManagerInterface $objectManager,
                                TransportInterfaceFactory $mailTransportFactory) {

        parent::__construct($templateFactory,
            $message,
            $senderResolver,
            $objectManager,
            $mailTransportFactory);

        $this->message = $message;
    }

    /**
     * @param $file_content
     * @param $name
     * @param string $file_type
     * @return $this
     */
    public function addAttachment($file_content, $name, $file_type = "application/pdf") {
        if (!empty($file_content) && !empty($name)) {
            $this->message
            ->createAttachment(
                $file_content,
                $file_type,
                \Zend_Mime::DISPOSITION_ATTACHMENT,
                \Zend_Mime::ENCODING_BASE64,
                basename($name)
                );
            }

        return $this;
    }

}
