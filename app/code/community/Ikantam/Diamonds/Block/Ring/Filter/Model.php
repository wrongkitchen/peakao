<?php

class Ikantam_Diamonds_Block_Ring_Filter_Model extends Mage_Core_Block_Template {

    public function __construct() {
        
    }

    public function getModels() {
        /* @var $collection Mage_Catalog_Model_Resource_Product_Collection */
        $collection = Mage::getResourceModel('catalog/product_collection');
        Mage::getModel('catalog/layer')->prepareProductCollection($collection);

        $ringId = Mage::helper('diamonds')->getRingId();

        $collection->addAttributeToFilter('type_id', array('eq' => 'configurable'))
                ->addAttributeToFilter('attribute_set_id', $ringId)
                ->addAttributeToSelect('ring_model');

        return $collection;
    }

}