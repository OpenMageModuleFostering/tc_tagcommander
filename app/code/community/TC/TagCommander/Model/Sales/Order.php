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
class TC_TagCommander_Model_Sales_Order {

    public function getOrdersToProcess() {
        try {

            return Mage::getModel('sales/order')->getCollection()
                            ->addAttributeToFilter('status', Mage::helper('tagcommander')->getOrdersStatus())
                            ->addAttributeToFilter('entity_id', array('gteq' => Mage::helper('tagcommander')->getStartFromOrderId()))
                            ->addAttributeToFilter('tagcommander_at', array('null' => true))
                            ->getAllIds();
            
        } catch (Exception $e) {

            Mage::helper('tagcommander')->_log($e->getMessage());
        }
    }

}
