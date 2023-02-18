<?php

namespace Lof\SalesRepCompatible\Controller\Adminhtml\Quote;


use Magento\Framework\ObjectManagerInterface;

/**
 * Class Edit
 * @package Lof\SalesRepCompatible\Controller\Adminhtml\Quote
 */
class Edit extends \Lof\SalesRepCompatible\Model\DependencyInjection\Expected
{
    /**
     * ReadHandler constructor.
     *
     * @param ObjectManagerInterface $objectManagerInterface
     * @param string                                    $name
     */
    public function __construct(
        ObjectManagerInterface $objectManagerInterface,
        $name = '\Lof\RequestForQuote\Controller\Adminhtml\Quote\Edit'
    ) {
        parent::__construct($objectManagerInterface, $name);
    }
}
