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

namespace Lof\SalesRep\Block\Adminhtml\Salesrep\Edit\Tab;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Locale\OptionInterface;


/**
 * @api
 * @since 100.0.2
 */
class Info extends \Magento\Backend\Block\Widget\Form\Generic
{
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
     * @var \Magento\Directory\Model\Config\Source\Country
     */
    protected $_countryFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Framework\Locale\ListsInterface $localeLists
     * @param \Magento\Directory\Model\Config\Source\Country $countryFactory
     * @param array $data
     * @param OptionInterface $deployedLocales Operates with deployed locales
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Framework\Locale\ListsInterface $localeLists,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Magento\Directory\Model\Config\Source\Country $countryFactory,
        array $data = [],
        OptionInterface $deployedLocales = null
    ) {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_authSession = $authSession;
        $this->_LocaleLists = $localeLists;
        $this->deployedLocales = $deployedLocales
            ?: ObjectManager::getInstance()->get(OptionInterface::class);
        parent::__construct($context, $registry, $formFactory, $data);
        $this->_countryFactory = $countryFactory;
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
        $model = $this->_coreRegistry->registry('permissions_user');
        if ($this->_isAllowedAction('Lof_SalesRep::salesrep_edit_info')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $baseFieldset = $form->addFieldset('salesrep_fieldset', ['legend' => __('Additional Info')]);
        $baseFieldset->addField('check_user_save', 'hidden', ['name' => 'check_user_save', 'id' => 'check_user_save']);
        $baseFieldset->addField('in_salesrep_customer', 'hidden', ['name' => 'in_salesrep_customer', 'id' => 'in_salesrep_customer']);

        $baseFieldset->addField('in_salesrep_customer_old', 'hidden', ['name' => 'in_salesrep_customer_old']);

        $baseFieldset->addField(
            'is_salesrep',
            'select',
            [
                'name' => 'is_salesrep',
                'label' => __('Is Sale Representative'),
                'id' => 'is_salesrep',
                'title' => __('Account Status'),
                'class' => 'input-select',
                'options' => ['1' => __('Yes'), '0' => __('No')],
                'note'      => __('Restrictions for viewing customers and orders will be applied for this role only.'),
                'disabled' => $isElementDisabled,
            ]
        );

        $wysiwygConfig = $this->_wysiwygConfig->getConfig(['tab_id' => $this->getTabId().time()]);
        $baseFieldset->addField(
            'salesrep_info',
            'editor',
            [
                'name'     => 'salesrep_info',
                'label'    => __('Sales Representative'),
                'style' => 'height:20em;',
                'disabled' => $isElementDisabled,
                'config' => $wysiwygConfig
            ]
        );


        $baseFieldset->addField(
            'bcc_email',
            'text',
            [
                'name' => 'bcc_email',
                'label'    => __('Bcc To'),
                'class' => 'requried-entry',
                'values' => 'bcc_email'
            ]
        );

        /*$baseFieldset->addField(
            'salesrep_commission',
            'text',
            [
                'name' => 'salesrep_commission',
                'label'    => __('Commission Per Product (%)'),
                'class' => 'input-text',
                'values' => 'salesrep_commission'
            ]
        );*/

        $baseFieldset->addField(
            'salesrep_phone',
            'text',
            [
                'name' => 'salesrep_phone',
                'label'    => __('Phone Number'),
                'class' => 'input-text',
                'values' => 'salesrep_phone'
            ]
        );

        $baseFieldset->addField(
            'salesrep_display_name',
            'text',
            [
                'name' => 'salesrep_display_name',
                'label'    => __('Display Name'),
                'class' => 'input-text',
                'values' => 'salesrep_display_name'
            ]
        );

        $baseFieldset->addField(
            'salesrep_address',
            'text',
            [
                'name' => 'salesrep_address',
                'label'    => __('Address'),
                'class' => 'input-text',
                'values' => 'salesrep_address'
            ]
        );

        $optionsc = $this->_countryFactory->toOptionArray();
        $baseFieldset->addField(
                'salesrep_country',
                'select',
                [
                    'name' => 'salesrep_country',
                    'label' => __('Country'),
                    'title' => __('Country'),
                    'values' => $optionsc,
                ]
            );

        $baseFieldset->addField(
            'salesrep_city_state',
            'text',
            [
                'name' => 'salesrep_city_state',
                'label'    => __('City or State'),
                'class' => 'input-text',
                'values' => 'salesrep_city_state'
            ]
        );

        $baseFieldset->addField(
            'salesrep_postcode',
            'text',
            [
                'name' => 'salesrep_postcode',
                'label'    => __('Postcode'),
                'class' => 'input-text',
                'values' => 'salesrep_postcode'
            ]
        );


        /*$baseFieldset->addField(
            'salesrep_total_balance',
            'text',
            [
                'name' => 'salesrep_total_balance',
                'label'    => __('Total Commission'),
                'class' => 'input-text',
                'values' => 'salesrep_total_balance'
            ]
        );*/


        $data = $model->getData();
        $form->setValues($data);
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
}
