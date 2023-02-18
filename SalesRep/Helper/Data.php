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

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;

/**
 * Class Data
 * @package Lof\SalesRep\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var \Magento\Directory\Model\Currency
     */
    protected $_currency;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $_localeDate;
    /**
     * @var Rate
     */
    protected $rate;
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $_priceCurrency;

    /**
     * @var null
     */
    protected $_enable_salesrep = null;

    /**
     * @var \Magento\Customer\Model\Session|null
     */
    protected $customerSession = null;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var array
     */
    private $postData = null;

    /**
     * @var \Magento\User\Model\UserFactory
     */
    protected $_userFactory;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Checkout\Model\Cart $cart
     * @param \Magento\Directory\Model\Currency $currency
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
     * @param \Magento\Tax\Model\Calculation\Rate $rate
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     * @param \Magento\Directory\Model\CountryFactory $countryFactory
     * @param \Magento\User\Model\UserFactory $userFactory
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Directory\Model\Currency $currency,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Tax\Model\Calculation\Rate $rate,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Directory\Model\CountryFactory $countryFactory,
        \Magento\User\Model\UserFactory $userFactory
    ) {
        parent::__construct($context);
        $this->customerSession        = $customerSession;
        $this->rate                   = $rate;
        $this->_currency              = $currency;
        $this->_storeManager          = $storeManager;
        $this->cart                   = $cart;
        $this->_localeDate            = $localeDate;
        $this->date                   = $date;
        $this->customerRepository   = $customerRepository;
        $this->_objectManager  = $objectManager;
        $this->_priceCurrency = $priceCurrency;
        $this->_countryFactory = $countryFactory;
        $this->_userFactory               = $userFactory;

    }

    /**
     * @param null $countryCode
     * @return string
     */
    public function getCountryname($countryCode = null)
    {
        if($countryCode) {
            $country = $this->_countryFactory->create()->loadByCode($countryCode);
            return $country->getName();
        }
        return '';
    }

    /**
     * @return \Magento\Customer\Api\Data\CustomerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getShippingAddress()
    {
        $customer = $this->customerRepository->getById($this->getCustomer()->getId());
        return $customer;
    }

    /**
     * @return bool|\Magento\Customer\Model\Customer
     */
    public function getCustomer()
    {
        if(null === $this->customerSession){
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $this->customerSession = $objectManager->get('Magento\Customer\Model\Session');
        }
        if (!$this->customerSession->isLoggedIn()) {
            return false;
        }
        return $this->customerSession->getCustomer();
    }

    /**
     * @return bool|\Magento\Customer\Api\Data\CustomerInterface
     */
    public function getCustomerData()
    {
        if(null === $this->customerSession){
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $this->customerSession = $objectManager->get('Magento\Customer\Model\Session');
        }
        if (!$this->customerSession->isLoggedIn()) {
            return false;
        }
        return $this->customerSession->getCustomerDataObject();
    }

    /**
     * @return \Magento\Framework\Data\Collection\AbstractDb|\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection|null
     */
    public function getRate()
    {
        return $this->rate->getCollection();
    }

    /**
     * @return mixed
     */
    public function getCurrentCurrencySymbol()
    {
        return $this->_priceCurrency->getCurrency()->getCurrencySymbol();
        //return $this->_currency->getCurrencySymbol();
    }

    /**
     * @param $price
     * @return mixed
     */
    public function formatPriceWithCurency($price)
    {
        $priceHelper = $this->_objectManager->create('Magento\Framework\Pricing\Helper\Data'); // Instance of
        return $priceHelper->currency($price, true, false);
    }

    /**
     * Return brand config value by key and store
     *
     * @param string $key
     * @param \Magento\Store\Model\Store|int|string $store
     * @return string|null
     */
    public function getConfig($key, $store = null)
    {
        if(!$store) {
            $store = $this->_objectManager->get('Magento\Store\Model\StoreManagerInterface')->getStore()->getId();
        }
        $store = $this->_storeManager->getStore($store);
        $websiteId = $store->getWebsiteId();

        $result = $this->scopeConfig->getValue(
            'salesrep/' . $key,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store);
        return $result;
    }

     /**
     * Return brand config value by key and store
     *
     * @param string $key
     * @param \Magento\Store\Model\Store|int|string $store
     * @return string|null
     */
    public function getSystemConfig($key, $store = null)
    {
        if(!$store) {
            $store = $this->_objectManager->get('Magento\Store\Model\StoreManagerInterface')->getStore()->getId();
        }
        $store = $this->_storeManager->getStore($store);
        $websiteId = $store->getWebsiteId();

        $result = $this->scopeConfig->getValue(
            'general/' . $key,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store);
        return $result;
    }
    /**
     * Get formatted price value including order currency rate to order website currency
     *
     * @param   float $price
     * @param   bool  $addBrackets
     * @return  string
     */
    public function formatPrice($price, $addBrackets = false, $currency_code = null)
    {
        return $this->formatPricePrecision($price, 2, $addBrackets, $currency_code);
    }

    /**
     * @param float $price
     * @param int $precision
     * @param bool $addBrackets
     * @return string
     */
    public function formatPricePrecision($price, $precision, $addBrackets = false, $currency_code = null)
    {
        if($currency_code) {
            $this->_currency->load($currency_code);
        }
        return $this->_currency->formatPrecision($price, $precision, [], true, $addBrackets);
    }

    /**
     * @param int $length
     * @return string
     */
    public function generateRandomString($length = 10)
    {
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Retrieve formatting date
     *
     * @param null|string|\DateTime $date
     * @param int $format
     * @param bool $showTime
     * @param null|string $timezone
     * @return string
     */
    public function formatDate(
        $date = null,
        $format = \IntlDateFormatter::SHORT,
        $showTime = false,
        $timezone = null
    ) {
        $date = $date instanceof \DateTimeInterface ? $date : new \DateTime($date);
        return $this->_localeDate->formatDateTime(
            $date,
            $format,
            $showTime ? $format : \IntlDateFormatter::NONE,
            null,
            $timezone
        );
    }
     /**
     * Get value from POST by key
     *
     * @param string $key
     * @return string
     */
    public function getPostValue($key)
    {
        if (null === $this->postData) {
            $this->postData = (array) $this->getDataPersistor()->get('quote_data');
            $this->getDataPersistor()->clear('quote_data');
        }

        if (isset($this->postData[$key])) {
            return (string) $this->postData[$key];
        }

        return '';
    }
    /**
     * Get Data Persistor
     *
     * @return DataPersistorInterface
     */
    private function getDataPersistor()
    {
        if ($this->dataPersistor === null) {
            $this->dataPersistor = ObjectManager::getInstance()
                ->get(DataPersistorInterface::class);
        }

        return $this->dataPersistor;
    }

    /**
     * @param $userId
     * @return \Magento\User\Model\User
     */
    public function getSalesRepById($userId)
    {
        $userInfo   = $this->_userFactory->create()->load($userId);
        return $userInfo;
    }


}
