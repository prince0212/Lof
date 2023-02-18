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

namespace Lof\SalesRep\Model\SalesRep\Attribute\Source;

/**
 * Customer group attribute source
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Salesrep extends \Magento\Eav\Model\Entity\Attribute\Source\Table
{

    /**
     * @var \Magento\User\Model\ResourceModel\User\CollectionFactory
     */
    protected $_userCollectionFactory;
    /**
     * @var GroupManagementInterface
     */
    protected $_groupManagement;

    /**
     * @var \Magento\Framework\Convert\DataObject
     */
    protected $_converter;

    /**
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory $attrOptionFactory
     * @param GroupManagementInterface $groupManagement
     * @param \Magento\Framework\Convert\DataObject $converter
     */
    public function __construct(
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory $attrOptionFactory,
        \Magento\User\Model\ResourceModel\User\CollectionFactory $userCollectionFactory,
        \Magento\Framework\Convert\DataObject $converter
    ) {
        $this->_userCollectionFactory = $userCollectionFactory;
        $this->_converter = $converter;
        parent::__construct($attrOptionCollectionFactory, $attrOptionFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function getAllOptions($withEmpty = true, $defaultValues = false)
    {
        if (!$this->_options) {
            $users = $this->_createUserCollection()->addFieldToFilter('is_salesrep', array('eq' => 1))->load();
            foreach ($users as $user){
                $this->_options[] = [
                    'value' => $user->getUserId(),
                    'label' => $user->getFirstName().' '.$user->getLastName()
                ];
            }
        }
        return $this->_options;
    }

    /**
     * @return \Magento\Directory\Model\ResourceModel\Region\Collection
     */
    protected function _createUserCollection()
    {
        return $this->_userCollectionFactory->create();
    }
}
