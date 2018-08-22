<?php

class Ikantam_Diamonds_Block_Product_List_Diamonds_Recently extends Ikantam_Diamonds_Block_Product_List_Diamonds {

    public function __construct() {
        $this->_initProductCollection();
        parent::__construct();
    }

    private function _initProductCollection() {
        if (is_null($this->_productCollection)) {
            /* @var $collection Ikantam_Diamonds_Model_Recently */
            $collection = Mage::getModel('diamonds/recently')->getDiamondsCollection();
            Mage::getModel('catalog/layer')->prepareProductCollection($collection);
            $collection->addStoreFilter();
            $this->_productCollection = $collection;
        }
    }

    public function getToolbarBlock() {
        $block = $this->getChild("rv_toolbar");
        $block->setCollection($this->_productCollection);
        return $block;
    }

}