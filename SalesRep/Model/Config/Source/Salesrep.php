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

namespace Lof\SalesRep\Model\Config\Source;

use Magento\Customer\Api\GroupManagementInterface;

/**
 * Customer group attribute source
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Salesrep implements \Magento\Framework\Option\ArrayInterface
{

    /**
     * @var \Magento\User\Model\ResourceModel\User\CollectionFactory
     */
    protected $_userFactory;
    /**
     * @var null
     */
    protected $_options = null;


    /**
     * Salesrep constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\User\Model\ResourceModel\User\CollectionFactory $userFactory
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\User\Model\ResourceModel\User\CollectionFactory $userFactory,
        \Magento\Backend\Model\Auth\Session $authSession,
        array $data = []
        ) {
        $this->_userFactory = $userFactory;
        $this->authSession = $authSession;
    }

    /**
     * @return \Magento\User\Model\User|null
     */
    public function getCurrentUser()
    {
        return $this->authSession->getUser();
    }

    /**
     * @return bool
     */
    public function isSalesrepUser(){
        $user = $this->getCurrentUser();
        if($user){
            $is_salesrep = $user->getIsSalesrep();
            if($is_salesrep){
                return true;
            }
        }
        return false;
    }

    /**
     * @return bool|\Magento\User\Model\ResourceModel\User\Collection
     */
    public function getListUsers(){
        $users = $this->_userFactory->create();
        $users->addFieldToFilter("is_salesrep",1);

        if($users && count($users) > 0){
            return $users;
        }
        return false;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $option = [];
        $users = $this->getListUsers();
        $current_user_id = 0;
        if($this->isSalesrepUser()){
            $current_user_id = $this->getCurrentUser()->getId();
        }

        if($users && count($users) > 0){
            $first_item = ['value' => '', 'label' => __("--- Choose a Sales Rep User ---")];
            $option[] = $first_item;
            foreach ($users as $user){
                if($current_user_id && ($user->getUserId() != $current_user_id))
                    continue;
                $username = $user->getSalesrepDisplayName();
                $username = $username?$username:($user->getFirstName().' '.$user->getLastName());
                $option[] = [
                    'value' => (int)$user->getUserId(),
                    'label' =>  $username
                ];
            }
        }
        return $option;
    }

    /**
     * @inheritdoc
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $current_user_id = 0;
            if($this->isSalesrepUser()){
                $current_user_id = $this->getCurrentUser()->getId();
            }
            $users = $this->getListUsers();
            if($users && count($users) > 0){
                $this->_options = array();
                $first_item = ['value' => '', 'label' => __("--- Choose a Sales Rep User ---")];
                $this->_options[] = $first_item;
                foreach ($users as $user){
                    if($current_user_id && ($user->getUserId() != $current_user_id))
                    continue;
                    $username = $user->getSalesrepDisplayName();
                    $username = $username?$username:($user->getFirstName().' '.$user->getLastName());
                    $item = ['value' => (int)$user->getUserId(), 'label' => $username];
                    $this->_options[] = $item;
                }
            }
        }

        return $this->_options;
    }

    /**
     * @inheritdoc
     */
    public function getOptionText($value)
    {
        $options = $this->getAllOptions();
        foreach ($options as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }

        return false;
    }
}
