<?php

namespace Lof\SalesRep\Block\Adminhtml\Salesrep;

use Lof\SalesRep\Model\ResourceModel\Sales\Order\Grid\Collection;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Model\Auth\Session;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Magento\Framework\Pricing\Helper\Data;
use Magento\Customer\Model\ResourceModel\Customer\Collection as CustomerCollection;

/**
 * Class Dashboard
 *
 * @package Lof\SalesRep\Block\Adminhtml\Salesrep
 */
class Dashboard extends \Magento\Backend\Block\Template {
    /**
     * @var Session
     */
    private $_authSession;
    /**
     * @var Data
     */
    private $priceHelper;
    /**
     * @var CollectionFactory
     */
    private $collection;
    /**
     * @var CustomerCollection
     */
    private $customerCollection;

    /**
     * Dashboard constructor.
     *
     * @param \Magento\Backend\Block\Template\Context                    $context
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $collection
     * @param \Magento\Backend\Model\Auth\Session                        $authSession
     * @param \Magento\Framework\Pricing\Helper\Data                     $priceHelper
     * @param \Magento\Customer\Model\ResourceModel\Customer\Collection  $customerCollection
     * @param \Magento\Framework\Json\Helper\Data|null                   $jsonHelper
     * @param \Magento\Directory\Helper\Data|null                        $directoryHelper
     * @param array                                                      $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $collection,
        Session $authSession,
        Data $priceHelper,
        CustomerCollection $customerCollection,
        ?JsonHelper $jsonHelper = null,
        ?DirectoryHelper $directoryHelper = null,
        array $data = []
    )
    {
        $this->_authSession       = $authSession;
        $this->collection         = $collection;
        $this->priceHelper        = $priceHelper;
        $this->customerCollection = $customerCollection;
        parent::__construct($context, $data, $jsonHelper, $directoryHelper);
    }


    /**
     * @return Collection
     */
    public function getCollection()
    {
        $currentUser = $this->_authSession->getUser();
        $userId      = $currentUser->getId();
        $isSalesRep  = $currentUser->getIsSalesrep();
        $collection  = $this->collection->create();
        if ($isSalesRep) {
            $collection->addFieldToFilter('salesrep_id', $userId);
        }

        return $collection;
    }

    /**
     * @return int
     */
    public function getTotalSales()
    {
        $collection = $this->getCollection();
        $total      = 0;
        foreach ($collection as $order) {
            $total += $order->getBaseGrandTotal();
        }

        return $total;
    }

    /**
     * @return int
     */
    public function getTotalDiscount()
    {
        $collection = $this->getCollection();
        $total      = 0;
        foreach ($collection as $order) {
            $total += $order->getBaseDiscountAmount();
        }

        return $total;
    }

    /**
     * @param $price
     * @return float|string
     */
    public function getPriceHtml($price)
    {
        return $this->priceHelper->currency($price, true, false);
    }

    /**
     * @return int|void
     */
    public function countCustomers()
    {
        $collection = $this->customerCollection;

        return count($collection);
    }
}
