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
    * @package Mycart_Payease
    * @copyright Copyright (c) 2015 Mage Delight (http://www.magedelight.com/)
    * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
    * @author Magedelight <info@magedelight.com>
    */
    class Mycart_Payease_IndexController extends Mage_Core_Controller_Front_Action
    {        
        public function deniedJsonAction()
        {
            $this->getResponse()->setBody($this->_getDeniedJson());
        }

        protected function _getDeniedJson()
        {
            $adminRoute= (string)Mage::getConfig()->getNode('admin/routers/adminhtml/args/frontName');
            return Mage::helper('core')->jsonEncode(array(
                'ajaxExpired' => 1,
                'ajaxRedirect' => Mage::getBaseUrl().$adminRoute
            ));
        }
    }
