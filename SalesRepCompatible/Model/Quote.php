<?php

namespace Lof\SalesRepCompatible\Model;

use Lof\SalesRepCompatible\Model\DependencyInjection\Expected;
use Magento\Framework\ObjectManagerInterface;


/**
 * Class Quote
 * @package Lof\SalesRepCompatible\Model\
 */
class Quote extends Expected
{
    /**
     * ReadHandler constructor.
     *
     * @param ObjectManagerInterface $objectManagerInterface
     * @param string                                    $name
     */
    public function __construct(
        ObjectManagerInterface $objectManagerInterface,
        $name = '\Lof\RequestForQuote\Model\Quote'
    ) {
        parent::__construct($objectManagerInterface, $name);
    }
}
