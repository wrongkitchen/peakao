<?php

class Ikantam_Diamonds_Block_Filter extends Mage_Core_Block_Template {

    public function getRingAttributeOptions($attributeName) {
        $config = Mage::getStoreConfig('ikantam_diamonds/attributes/ring/' . $attributeName);
        return $config;
    }

    public function getDiamondsAttributeOptions($attributeName) {
        $config = Mage::getStoreConfig('ikantam_diamonds/attributes/diamond/' . $attributeName);
        return $config;
    }

}