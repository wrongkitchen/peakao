<?php

class Ikantam_Diamonds_Block_Ring_Product_List_Toolbar extends Mage_Catalog_Block_Product_List_Toolbar {

    protected $_defaultAvailableLimit = array(8 => 8, 16 => 16, 32 => 32, 50 => 50);

    protected function _construct() {
        parent::_construct();
    }

    public function getAvailableLimit() {
        return $this->_defaultAvailableLimit;
    }

}