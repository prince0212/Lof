# Mage2 Module Sales Rep

    ``landofcoder/module-sales-rep``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)

## Main Functionalities
    Sales Representative For Order, Invoice, Shipment, Customer, CMS Page, CMS Block, Request For Quote, B2B Company Account

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Lof`
 - Enable the module by running `php bin/magento module:enable Lof_SalesRep`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require landofcoder/module-sales-rep`
 - enable the module by running `php bin/magento module:enable Lof_CompanyProfile`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


