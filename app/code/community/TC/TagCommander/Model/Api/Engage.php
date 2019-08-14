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
class TC_TagCommander_Model_Api_Engage {

    const URI = "https://api.commander1.com/engage";

    public function putConversion($_data) {

        $_path = 'conversion/';

        return $this->call($_path, $_data);
    }
    
    public function putUser($_data) {               

        $_path = 'user/';
        
        $opt_params = array(
            'user_id' => $_data['entity_id'],
            );

        return $this->call($_path, $_data,$opt_params);
    }

    private function call($path, array $data,array $opt_params = array()) {

        $url = self::URI . DS . $path;

        try {                        

            $params = array(
                'site' => Mage::helper('tagcommander')->getId(),
                'token' => Mage::helper('tagcommander')->getToken(),
            );
            
            $params = array_merge($opt_params,$params);
            
            $url = $url . "?" . http_build_query($params);                                     

            $client = new Zend_Http_Client($url, array(
                'maxredirects' => 0,
                'timeout' => 5,
                'keepalive' => 1,
            ));
            
            $json = Mage::helper('core')->jsonEncode($data);
            $client->setRawData($json, 'application/json');               
            
            $response = $client->request('PUT');            
            $result = Zend_Json::decode($response->getBody());            
            
            if($result['success'] == true){
                return true;
            } else {
                return $response->getStatus().' '.$response->getMessage();
            }
            
        } catch (Exception $e) {
            
            Mage::helper('tagcommander')->_log($e->getMessage());
            return $e->getMessage();

        }
    }

}
