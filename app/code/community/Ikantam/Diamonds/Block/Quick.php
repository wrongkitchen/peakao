<?php

class Ikantam_Diamonds_Block_Quick extends Mage_Core_Block_Template {

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('diamonds/quick.phtml');
    }

    public function getAttributeShapeOptions(){
        $attrModel = Mage::getModel('catalog/product')
            ->getResource()
            ->getAttribute('diamond_shape');

        $attrId = $attrModel->getId();
        $attributeShapeOptions = Mage::getResourceModel('eav/entity_attribute_option_collection')
            ->setOrder('sort_order','asc')
            ->setAttributeFilter($attrId)
            ->setStoreFilter()
            ->load();

        return $attributeShapeOptions;
    }

}