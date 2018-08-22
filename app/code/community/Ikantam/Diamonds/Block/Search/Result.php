<?php

class Ikantam_Diamonds_Block_Search_Result extends Mage_Core_Block_Template {

    public function isActive() {
        if (Mage::getSingleton('core/session')->getDiamondSearchQuery()) {
            return true;
        }
        return false;
    }

    public function getRingsSize() {
        $size = Mage::getSingleton('core/session')->getDiamondSearchSize();
        if (is_array($size) && isset($size['rings'])) {
            return $size['rings'];
        }
        return 0;
    }

    public function getDiamondsSize() {
        $size = Mage::getSingleton('core/session')->getDiamondSearchSize();
        if (is_array($size) && isset($size['diamonds'])) {
            return $size['diamonds'];
        }
        return 0;
    }

}