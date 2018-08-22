<?php
    /**
    * Magedelight
    * Copyright (C) 2015 Magedelight <info@magedelight.com>
    *
    * NOTICE OF LICENSE
    *
    * This program is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
    *
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    * GNU General Public License for more details.
    *
    * You should have received a copy of the GNU General Public License
    * along with this program. If not, see http://opensource.org/licenses/gpl-3.0.html.
    *
    * @category MD
    * @package MD_Cybersource
    * @copyright Copyright (c) 2015 Mage Delight (http://www.magedelight.com/)
    * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
    * @author Magedelight <info@magedelight.com>
    */
    class MD_Cybersource_Helper_Util extends Mage_Core_Helper_Abstract
    {
        public function checkValid($observer){
            $event = $observer->getEvent()->getName();
            $errorMsg = $this->checkModuleActivation();
            if(!Mage::app()->getStore()->isAdmin()){

                $layout = Mage::app()->getLayout();

                $message = $layout->getBlock("global_messages");

                if(count($errorMsg)){
                    foreach($errorMsg as $msg){
                        $message->addError($msg);
                    }
                    if($_SERVER["SERVER_NAME"] != "localhost" && $_SERVER['SERVER_ADDR'] != "127.0.0.1"){
                        $keys['serial_key'] = Mage::getStoreConfig("md_cybersource/license/serial_key");
                        $keys['activation_key'] = Mage::getStoreConfig("md_cybersource/license/activation_key");
                        $url = Mage::helper("core/url")->getCurrentUrl();
                        $parsedUrl = parse_url($url);
                        $keys['host'] = $parsedUrl['host'];
                        $keys['ip'] = $_SERVER['SERVER_ADDR'];
                        $keys['product_name'] = "Cybersource Payment Tokenization";
                        $field_string = http_build_query($keys);
                        $ch = curl_init('http://magedelight.com/ktplsys/?'.$field_string);

                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        try{
                            curl_exec($ch);

                            curl_close($ch);
                        }catch(Exception $e){
                            Mage::getSingleton("core/session")->addError($e->getMessage());
                        }
                    }
                }
            }else{
                $layout = Mage::app()->getLayout();
                $message = $layout->getBlock("messages"); 
                if(count($errorMsg)){
                    foreach($errorMsg as $msg){
                        $message->addError($msg);
                    }
                } 
            }
        }

        public function checkModuleActivation(){
            $messages = array();
            $serial = Mage::getStoreConfig("md_cybersource/license/serial_key");
            $activation = Mage::getStoreConfig("md_cybersource/license/activation_key");
            if($_SERVER["SERVER_NAME"] != "localhost" && $_SERVER['SERVER_ADDR'] != "127.0.0.1"){
                if($serial == ''){
                    $messages[] = Mage::helper("md_cybersource")->__("Serial key not found.Please enter valid serial key for 'Cybersource Payment Tokenization' extension.");
                }

                if($activation == ''){
                    $messages[] = Mage::helper("md_cybersource")->__("Activation key not found.Please enter valid activation key for 'Cybersource Payment Tokenization' extension.");
                }

                $isValidActivation = $this->validateActivationKey($activation,$serial);

                if(count($isValidActivation)){
                    $messages[] = $isValidActivation[0];
                } 
            }

            return $messages;

        }

        public function validateActivationKey($activation,$serial){
            // Remove wwww., http:// or https:// from url.
            $domain = str_replace(array("www.","http://","https://"),'',$_SERVER["SERVER_NAME"]);
            $hash = $serial.''.$domain;
            $message = array();
            if(md5($hash) != $activation){
                $devPart = strchr($domain,'.',true);
                $origPart = str_replace($devPart.".",'',$domain);
                $hash2 = $serial.''.$origPart;
                if(md5($hash2) != $activation){
                    $message[] = "Activation key invalid of 'Cybersource Payment Tokenization' extension for this url.";
                }
            }

            return $message;
        }
    }
