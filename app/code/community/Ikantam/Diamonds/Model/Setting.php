<?php

class Ikantam_Diamonds_Model_Setting {

    private $_product;

    public function __construct($product) {
        $this->_product = $product;
    }

    public function getRelatedProducts($attributeCode, $attributeValue, $attributeForSelect = null) {
        $parentIds = Mage::getResourceSingleton('catalog/product_type_configurable')
                ->getParentIdsByChild($this->_product->getId());
        if (!count($parentIds)) {
            return array();
        }

        $configProduct = Mage::getModel('catalog/product')->load($parentIds[0]);

        $configProduct = Mage::getModel('catalog/product_type_configurable')
                ->setProduct($configProduct);
        $products = $configProduct->getUsedProductCollection()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter($attributeCode, $attributeValue)
                ->addFilterByRequiredOptions();

        if (is_null($attributeForSelect)) {
            return $products;
        }

        /* 23.08.2013 */
        $returnProducts = array();
        foreach ($products as $product) {
            /* $attribute = $product->getResource()
              ->getAttribute($attributeForSelect)
              ->getFrontend();
              $attrValue = $attribute->getValue($product); */
            $attrValue = Mage::getModel('catalog/product')
                    ->load($product->getId())
                    ->getAttributeText($attributeForSelect);
            $returnProducts[] = array(
                'value' => $attrValue,
                'url' => Mage::helper('diamonds')->getSettingUrl($product),
                'product' => $product
            );
        }
        /* End 23.08.2013 */

        return $returnProducts;
    }

}