<?php
namespace Lof\SalesRep\Model\ResourceModel\Order\Customer;


/**
 * Class Collection
 * @package Lof\SalesRep\Model\ResourceModel\Order\Customer
 */
class Collection extends \Magento\Customer\Model\ResourceModel\Customer\Collection
{
    /**
     * @return $this|Collection
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->addNameToSelect()->addAttributeToSelect(
            'email'
        )->addAttributeToSelect(
            'created_at'
        )->joinAttribute(
            'billing_postcode',
            'customer_address/postcode',
            'default_billing',
            null,
            'left'
        )->joinAttribute(
            'billing_city',
            'customer_address/city',
            'default_billing',
            null,
            'left'
        )->joinAttribute(
            'billing_telephone',
            'customer_address/telephone',
            'default_billing',
            null,
            'left'
        )->joinAttribute(
            'billing_regione',
            'customer_address/region',
            'default_billing',
            null,
            'left'
        )->joinAttribute(
            'billing_country_id',
            'customer_address/country_id',
            'default_billing',
            null,
            'left'
        )->joinField(
            'store_name',
            'store',
            'name',
            'store_id=store_id',
            null,
            'left'
        )->joinField(
            'website_name',
            'store_website',
            'name',
            'website_id=website_id',
            null,
            'left'
        );
        $objectManager  = \Magento\Framework\App\ObjectManager::getInstance();
        $authSession   = $objectManager->get('\Magento\Backend\Model\Auth\Session');
        $currentUser = $authSession->getUser();
        $userId = $currentUser->getId();
        $isSalesRep = $currentUser->getIsSalesrep();
        if ($isSalesRep) {
            $connection = $this->getConnection();
            $tableName = $this->getTable( 'lof_salesrep_customer' );
            $fields = array('customer_id');
            $sql = $connection->select()
                ->from( $tableName, $fields )
                ->where( 'user_id = ?', $userId );
            $result = $connection->fetchAll($sql);
            $customerIds = [];
            foreach ($result as $key => $value) {
                $customerIds[] = $value['customer_id'];
            }
            $this->addFieldToFilter( 'entity_id', array( 'in' => $customerIds ));
        }
        return $this;
    }
}
