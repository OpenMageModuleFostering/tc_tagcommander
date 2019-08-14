<?php

/**
 * TagCommander
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licence@tagcommander.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Tenbucks to newer
 * versions in the future.
 *
 * @category   TagCommander
 * @package    TC_TagCommander
 * @copyright  Copyright (c) 2016 TagCommander (http://www.tagcommander.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Webincolor <contact@webincolor.fr>
 */
class TC_TagCommander_Helper_Data extends Mage_Core_Helper_Abstract {

    const LOG_FILE = 'tagcommander.log';
    
    const XML_CONFIG_TAGCOMMANDER_GENERAL_ID = 'tagcommander/general/id';  
    const XML_CONFIG_TAGCOMMANDER_GENERAL_TOKEN = 'tagcommander/general/token';
    
    const XML_CONFIG_TAGCOMMANDER_ORDERS_ENABLE = 'tagcommander/orders/enable';
    const XML_CONFIG_TAGCOMMANDER_ORDERS_STATUS = 'tagcommander/orders/status';
    const XML_CONFIG_TAGCOMMANDER_ORDERS_START_FROM_ORDER_ID = 'tagcommander/orders/start_from_order_id';
    const XML_CONFIG_TAGCOMMANDER_ORDERS_COMMENT = 'tagcommander/orders/comment';
    const XML_CONFIG_TAGCOMMANDER_ORDERS_PAID = 'tagcommander/orders/paid';
    
    const XML_CONFIG_TAGCOMMANDER_CUSTOMERS_ENABLE = 'tagcommander/orders/enable';

    public function getId($storeId = null) {
        return Mage::getStoreConfig(self::XML_CONFIG_TAGCOMMANDER_GENERAL_ID, $storeId);
    }    

    public function getToken($storeId = null) {
        return Mage::getStoreConfig(self::XML_CONFIG_TAGCOMMANDER_GENERAL_TOKEN, $storeId);
    }

    public function isOrdersEnable($storeId = null) {
        return Mage::getStoreConfigFlag(self::XML_CONFIG_TAGCOMMANDER_ORDERS_ENABLE, $storeId);
    }

    public function getOrdersStatus($storeId = null) {
        return Mage::getStoreConfig(self::XML_CONFIG_TAGCOMMANDER_ORDERS_STATUS, $storeId);
    }

    public function getStartFromOrderId($storeId = null) {

        if ((int) Mage::getStoreConfig(self::XML_CONFIG_TAGCOMMANDER_ORDERS_START_FROM_ORDER_ID, $storeId) > 0) {
            return (int) Mage::getStoreConfig(self::XML_CONFIG_TAGCOMMANDER_ORDERS_START_FROM_ORDER_ID, $storeId);
        }
        return 1;
    }
    
    public function isAddComment($storeId = null) {
        return Mage::getStoreConfigFlag(self::XML_CONFIG_TAGCOMMANDER_ORDERS_COMMENT, $storeId);
    }
        
    public function isOrderPaid($storeId = null) {
        return Mage::getStoreConfigFlag(self::XML_CONFIG_TAGCOMMANDER_ORDERS_PAID, $storeId);
    }

    public function isCustomersEnable($storeId = null) {
        return Mage::getStoreConfigFlag(self::XML_CONFIG_TAGCOMMANDER_CUSTOMERS_ENABLE, $storeId);
    }

    public function _log($message) {
        Mage::log($message, NULL, self::LOG_FILE);
    }

}
