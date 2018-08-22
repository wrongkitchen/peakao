<?php

class Mycart_Randombanner_Model_Banner extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('randombanner/banner');
    }
}