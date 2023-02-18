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

namespace Lof\SalesRep\Block\Adminhtml\SalesrepInfo\Edit\Tab;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Locale\OptionInterface;

/**
 * Class SalesrepInfoParent
 *
 * @package Lof\SalesRep\Block\Adminhtml\SalesrepInfo\Edit\Tab
 */
class SalesrepInfoParent extends \Magento\Backend\Block\Widget\Form\Generic {
    /**
     *
     */
    const CURRENT_USER_PASSWORD_FIELD = 'current_password';

    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;
    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $_authSession;

    /**
     * @var \Magento\Framework\Locale\ListsInterface
     */
    protected $_LocaleLists;

    /**
     * Operates with deployed locales.
     *
     * @var OptionInterface
     */
    private $deployedLocales;

    /**
     * @var \Magento\User\Model\UserFactory
     */
    protected $_userFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context  $context
     * @param \Magento\Framework\Registry              $registry
     * @param \Magento\Framework\Data\FormFactory      $formFactory
     * @param \Magento\Backend\Model\Auth\Session      $authSession
     * @param \Magento\Framework\Locale\ListsInterface $localeLists
     * @param array                                    $data
     * @param OptionInterface                          $deployedLocales Operates with deployed locales.
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Framework\Locale\ListsInterface $localeLists,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Magento\User\Model\UserFactory $userFactory,
        array $data = [],
        OptionInterface $deployedLocales = null
    )
    {
        $this->_wysiwygConfig  = $wysiwygConfig;
        $this->_authSession    = $authSession;
        $this->_LocaleLists    = $localeLists;
        $this->deployedLocales = $deployedLocales
            ?: ObjectManager::getInstance()->get(OptionInterface::class);
        parent::__construct($context, $registry, $formFactory, $data);
        $this->_userFactory = $userFactory;
    }

    /**
     * Prepare form fields
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {
        /** @var $model \Magento\User\Model\User */
        $userId = $this->getCurrentSalerep();
        if ($userId) {
            $model = $this->_userFactory->create()->load($userId);
        }

        if ($this->_isAllowedAction('Lof_SalesRep::salesrep_edit_info')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $baseFieldset = $form->addFieldset('salesrep_fieldset', ['legend' => __('Sale Representative Info')]);

        $baseFieldset->addField(
            'user_id',
            'select',
            [
                'name'           => 'user_id',
                'label'          => __('Sale Representative'),
                'id'             => 'user_id',
                'title'          => __('Sale Representative'),
                'class'          => 'input-select',
                'data-form-part' => 'customer_form',
                'options'        => $this->toOptionArray(),
                'disabled'       => $isElementDisabled,
            ]
        );

        if (isset($model)) {
            $baseFieldset->addType('custom_field', '\Lof\SalesRep\Block\Adminhtml\SalesrepInfo\Renderer\SalesrepInfo');
            $baseFieldset->addField(
                'salesrep_info',
                'custom_field',
                [
                    'name'  => 'salesrep_info',
                    'label' => __('Information'),
                    'title' => __('Information'),
                ]
            );

            $baseFieldset->addField(
                'email',
                'text',
                [
                    'name'     => 'email',
                    'label'    => __('Email'),
                    'title'    => __('Email'),
                    'disabled' => true,
                ]
            );

            $baseFieldset->addField(
                'bcc_email',
                'text',
                [
                    'name'     => 'bcc_email',
                    'label'    => __('Bcc Emails'),
                    'title'    => __('Bcc Emails'),
                    'disabled' => true,
                ]
            );

            $baseFieldset->addField(
                'salesrep_phone',
                'text',
                [
                    'name'     => 'salesrep_phone',
                    'label'    => __('Telephone'),
                    'title'    => __('Telephone'),
                    'disabled' => true,
                ]
            );

            $baseFieldset->addField(
                'salesrep_display_name',
                'text',
                [
                    'name'     => 'salesrep_display_name',
                    'label'    => __('Display Name'),
                    'title'    => __('Display Name'),
                    'disabled' => true,
                ]
            );

            $baseFieldset->addField(
                'salesrep_address',
                'text',
                [
                    'name'     => 'salesrep_address',
                    'label'    => __('Address'),
                    'title'    => __('Address'),
                    'disabled' => true,
                ]
            );

            $baseFieldset->addField(
                'salesrep_city_state',
                'text',
                [
                    'name'     => 'salesrep_city_state',
                    'label'    => __('City or State'),
                    'title'    => __('City or State'),
                    'disabled' => true,
                ]
            );

            $baseFieldset->addField(
                'salesrep_postcode',
                'text',
                [
                    'name'     => 'salesrep_postcode',
                    'label'    => __('Postcode'),
                    'title'    => __('Postcode'),
                    'disabled' => true,
                ]
            );

            $data = $model->getData();
            $form->setValues($data);
        }
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * @return |null
     */
    protected function getCurrentSalerep()
    {
        return null;
    }

    /**
     * Retrieve all region options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $this->_options = ['0' => __('Admin')];
        $users          = $this->_userFactory->create()->getCollection()->addFieldToFilter('is_salesrep', ['eq' => 1])->load();
        if ($users && count($users) > 0) {
            foreach ($users as $user) {
                $user_name                          = $user->getSalesrepDisplayName();
                $this->_options[$user->getUserId()] = $user_name ? $user_name : ($user->getFirstName() . ' ' . $user->getLastName());
            }
        }

        return $this->_options;
    }
}
