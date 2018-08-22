<?php

class Mycart_Randombanner_Model_Mysql4_Banner extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
     $this->_init('randombanner/banner', 'banner_id');
    }
}