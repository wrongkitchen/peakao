<?php

class Ikantam_Diamonds_Block_Product_List_Toolbar extends Mage_Catalog_Block_Product_List_Toolbar {

    protected $_availableOrder;

    protected function _construct() {
        parent::_construct();
        $helper = Mage::helper('diamonds/config');
                
        /* @var $helper Ikantam_Diamonds_Helper_Config */
        $this->_availableMode = array(
            'comparison' => $this->__('Comparison'),
            'list' => $this->__('List'),
            'grid' => $this->__('Grid')
        );
        $this->_availableLimit = array(
            'grid' => $helper->getModeGridLimit(), 
            'list' => $helper->getModeListLimit(), 
            'comparison' => $helper->getModeCompareLimit()
        );
    }

    private function _initAvailableOrder() {
        $this->_availableOrder = array(
            'diamond_shape' => $this->__('Shape'),
            'carat' => $this->__('Carat'),
            'clarity' => $this->__('Clarity'),
            'cut' => $this->__('Cut'),
            'price' => $this->__('Price')
        );

        $colorCode = Ikantam_Diamonds_Model_Config::LOOSE_COLOR;
        if (Mage::registry('is_fancy')) {
            $colorCode = Ikantam_Diamonds_Model_Config::FANCY_COLOR;
        }

        $this->_availableOrder[$colorCode] = $this->__('顏色');
    }

    public function getAvailableOrders() {
        $this->_initAvailableOrder();
        return $this->_availableOrder;
    }

    protected function _getAvailableLimit($mode) {
        if (!isset($this->_availableLimit[$mode])) {
            return array();
        }
        $limits = $this->_availableLimit[$mode];
        $perPageValues = explode(',', $limits);
        $perPageValues = array_combine($perPageValues, $perPageValues);
        if (Mage::getStoreConfigFlag('catalog/frontend/list_allow_all')) {
            return ($perPageValues + array('all' => $this->__('All')));
        } else {
            return $perPageValues;
        }
    }

    public function getAvailableLimit() {
        $currentMode = $this->getCurrentMode();
        if (in_array($currentMode, array('list', 'grid', 'comparison'))) {
            return $this->_getAvailableLimit($currentMode);
        } else {
            return $this->_defaultAvailableLimit;
        }
    }

}