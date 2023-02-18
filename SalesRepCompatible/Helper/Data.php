<?php
namespace Lof\SalesRepCompatible\Helper;

use Lof\SalesRepCompatible\Model\DependencyInjection\Expected;

/**
 * Class Data
 * @package Lof\SalesRepCompatible\Helper
 */
class Data
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * Data constructor.
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Framework\ObjectManagerInterface $objectManager
    ) {
        $this->moduleManager = $moduleManager;
        $this->objectManager = $objectManager;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        $arg = ['name' => $data];
        return $this->objectManager->create('\Lof\SalesRepCompatible\Model\DependencyInjection\Expected', $arg);
    }
}
