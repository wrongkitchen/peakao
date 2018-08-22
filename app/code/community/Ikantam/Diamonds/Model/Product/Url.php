<?php

class Ikantam_Diamonds_Model_Product_Url extends Mage_Catalog_Model_Product_Url {

    public function getUrl(Mage_Catalog_Model_Product $product, $params = array()) {

        $helperSet = new Ikantam_Diamonds_Helper_Set();
        $helper = new Ikantam_Diamonds_Helper_Data();

        if ($helperSet->isDiamond($product)) {
            $url = $helper->getDiamondUrl($product);
            return $url;
        }

        if ($helperSet->isRing($product)) {
            $url = $helper->getSettingUrl($product);
            return $url;
        }

        return parent::getUrl($product, $params);
    }

}