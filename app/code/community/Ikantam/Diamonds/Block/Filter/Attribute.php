<?php

class Ikantam_Diamonds_Block_Filter_Attribute extends Mage_Core_Block_Template {

    public function getAttributeOptions($attributeName) {

        $attrModel = Mage::getModel('catalog/product')
                ->getResource()
                ->getAttribute($attributeName);
        if (!$attrModel) {
            return array();
        }

        $attrId = $attrModel->getId();
        /* @var $attributeOptions Mage_Eav_Model_Resource_Entity_Attribute_Option_Collection */
        $attributeOptions = Mage::getResourceModel('eav/entity_attribute_option_collection');
        $attributeOptions->setPositionOrder()
                ->setAttributeFilter($attrId)
                ->setStoreFilter()
                ->load();
        /*->setOrder('option_id', 'asc')*/
                
        return $attributeOptions;
    }

    public function getDefaultOption($attributeName) {
        $attributes = $this->getRequest()->getParam('attributes');
        if ($attributes && isset($attributes[$attributeName])) {
            $attribute = $attributes[$attributeName];
            return $attribute;
        }
    }

}