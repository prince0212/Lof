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

namespace Lof\SalesRep\Model\Permission;

/**
 * Class PermissionManagement
 * @package Magestore\InventorySuccess\Model\Permission
 */
class PermissionManagement  extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var \Magento\Framework\Authorization\PolicyInterface
     */
    protected $_policyInterface;

    /**
     * @var \Magento\Framework\AuthorizationInterface
     */
    protected $_authorizationInterface;

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $_authSession;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Lof\SalesRep\Helper\Data
     */
    protected $_salesrepHelper;

    /**
     *
     */
    public function _construct(){

    }

    /**
     * PermissionManagement constructor.
     * @param \Magento\Framework\AuthorizationInterface $authorizationInterface
     * @param \Magento\Framework\Authorization\PolicyInterface $policyInterface
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param QueryProcessorInterface $queryProcessor
     * @param \Magento\Framework\Authorization\RoleLocatorInterface $roleLocator
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     */
    public function __construct(
        \Magento\Framework\AuthorizationInterface $authorizationInterface,
        \Magento\Framework\Authorization\PolicyInterface $policyInterface,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\Authorization\RoleLocatorInterface $roleLocator,
        \Lof\SalesRep\Helper\Data $salesrepHelper,
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ){
        parent::__construct( $context );
        $this->_authorizationInterface = $authorizationInterface;
        $this->_policyInterface = $policyInterface;
        $this->_authSession = $authSession;
        $this->_coreRegistry = $coreRegistry;
        $this->_salesrepHelper = $salesrepHelper;
    }

    /**
     * @param $resourceId
     * @param PermissionTypeInterface|null $object
     * @param null $userId
     * @return bool
     */
    public function checkPermission( $resourceId, $userId  = null){
        $showAssignTab = $this->_salesrepHelper->getConfig('general/edit_no_grid');
        $userPermissions = $this->_coreRegistry->registry('permissions_user');
        if($userPermissions->getUserId()){
            if(!$this->_authorizationInterface->isAllowed($resourceId)){
                return false;
            }else{
                $isSalesrep = $userPermissions->getIsSalesrep();
                if( $isSalesrep == 1 && !$showAssignTab){
                    return false;
                }elseif( $isSalesrep == 0){
                    return false;
                }
            }
        }else{
            return false;
        }

        return true;
    }

    /**
     * @param $config
     * @return bool
     */
    public function allowAssignOtherDealer($config){
        $seeOtherDealers = $this->_salesrepHelper->getConfig($config);
        $userId = $this->_authSession->getUser()->getId();
        $isSalesrep = $this->_authSession->getUser()->getIsSalesrep();
        if( $isSalesrep  && !$seeOtherDealers){
        	return false;
        }
        return true;

    }

    /**
     * @param $resourceId
     * @param $config
     * @param null $userId
     * @return bool
     */
    public function allowShowTab($resourceId, $config, $userId  = null ){
        $showAssignTab = $this->_salesrepHelper->getConfig($config);
        if(!$this->_authorizationInterface->isAllowed($resourceId)){
            return false;
        }
        if(!$userId){
            $userId = $this->_authSession->getUser()->getId();
        }
        $isSalesrep = $this->_authSession->getUser()->getIsSalesrep();

        if( $isSalesrep  && !$showAssignTab){
        	return false;
        }
        return true;

    }
}
