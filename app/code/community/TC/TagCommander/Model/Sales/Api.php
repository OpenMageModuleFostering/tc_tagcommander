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
class TC_TagCommander_Model_Sales_Api {

    public function send() {

        try {

            $i = 0;
            foreach (Mage::getModel('tagcommander/sales_order')->getOrdersToProcess() as $orderId) {
                $order = Mage::getModel('sales/order')->load($orderId);
                $data = array();

                // Check if order is paid.
                if (Mage::helper('tagcommander')->isOrderPaid() && $order->getBaseTotalDue() > 0)
                    continue;

                // Get Order infos
                $data = $order->getData();
                $data['billing_address'] = $order->getBillingAddress()->getData();
                $data['shipping_address'] = $order->getShippingAddress()->getData();

                //get Order items
                foreach ($order->getAllItems() as $item) {
                    $data['items'][] = $item->getData();
                }
                
                $response = Mage::getSingleton('tagcommander/api_engage')->putConversion($data);

                if ($response == 1) {

                    $order->setData('tagcommander_at', date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time())));

                    if (Mage::helper('tagcommander')->isAddComment()) {
                        $comment = Mage::helper('tagcommander')->__('<strong>TagCommander</strong>: Order sent.');
                        $order->setState($order->getState(), $order->getStatus(), $comment, false);
                    }

                    $order->save();
                    $i++;
                } else {
                     Mage::throwException($response);
                }
            }

            return Mage::helper('tagcommander')->__('%s orders processed', $i);
        } catch (Exception $e) {
            Mage::helper('tagcommander')->_log($e->getMessage());
            return $e->getMessage();
        }
    }

}
