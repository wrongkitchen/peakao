<?php

class Ikantam_Diamonds_Helper_Data extends Mage_Core_Helper_Abstract {

    public function getConditionBySign($sign) {
        $condMap = array(
            'min' => 'gteq',
            'max' => 'lteq',
            'mass' => 'in'
        );

        if (isset($condMap[$sign])) {
            return $condMap[$sign];
        }
        return null;
    }

    public function getAddRingToCartUrl($product) {
        $url = Mage::getUrl("design/product/addtocart/type/".Mage::registry("design_type"), array('product' => $product->getId(),'_nosid' => true));
        return $url;
    }
    
    public function getAddToRingUrl($product) {
        $url = Mage::getUrl("design/constructor/diamond/type/".Mage::registry("design_type"), array('diamond_id' => $product->getId(), '_nosid' => true));
        return $url;
    }

    public function getSelectSettingUrl($product) {
        $url = Mage::getUrl("design/constructor/setting/type/".Mage::registry("design_type"), array( 'ring_id' => $product->getId(), '_nosid' => true));
        return $url;
    }

    public function getChooseDiamondsUrl() {
        $url = Mage::getUrl("design/diamond/index/type/".Mage::registry("design_type"));
        return $url;
    }

    public function getChooseSettingsUrl() {
        $url = Mage::getUrl("design/settings/index/type/".Mage::registry("design_type"));
        return $url;
    }

    public function convertShapeForRing($diamondsShape) {

        if (is_numeric($diamondsShape)) {
            $attributeOptions = Mage::getResourceModel('eav/entity_attribute_option_collection')
                    ->addFieldToFilter("main_table.option_id", $diamondsShape)
                    ->setStoreFilter()
                    ->load();

            if (!$attributeOptions) {
                return null;
            }

            $shapeStr = $attributeOptions->getFirstItem()->getValue();
        } elseif (is_string($diamondsShape)) {

            $shapeStr = $diamondsShape;
        } else {
            return null;
        }

        $attrModel = Mage::getModel('catalog/product')
                ->getResource()
                ->getAttribute("ring_mainstone_shape");

        $attributeOptions = Mage::getResourceModel('eav/entity_attribute_option_collection')
                ->setAttributeFilter($attrModel->getId())
                ->setStoreFilter()
                ->load();
        foreach ($attributeOptions as $option) {
            if ($option->getValue() == $shapeStr) {
                return $option->getId();
            }
        }

        return null;
    }
    
    

    public function convertShapeForDiamond($ringShape) {

        if (is_numeric($ringShape)) {
            $attributeOptions = Mage::getResourceModel('eav/entity_attribute_option_collection')
                    ->addFieldToFilter("main_table.option_id", $ringShape)
                    ->setStoreFilter()
                    ->load();

            if (!$attributeOptions) {
                return null;
            }

            $shapeStr = $attributeOptions->getFirstItem()->getValue();
        } elseif (is_string($ringShape)) {

            $shapeStr = $ringShape;
        } else {
            return null;
        }

        $attrModel = Mage::getModel('catalog/product')
                ->getResource()
                ->getAttribute("diamond_shape");

        $attributeOptions = Mage::getResourceModel('eav/entity_attribute_option_collection')
                ->setAttributeFilter($attrModel->getId())
                ->setStoreFilter()
                ->load();
        foreach ($attributeOptions as $option) {
            if ($option->getValue() == $shapeStr) {
                return $option->getId();
            }
        }

        return null;
    }
    
    
    public function getDiamondUrl($product) {
        if ($product && $id = $product->getId()) {
            if (Mage::helper('diamonds/config')->isEnableSeoLink()){
                 $url = Mage::getBaseUrl() . $product->getUrlKey() . '.html';
            }
            else{
                $url = Mage::getBaseUrl() . 'design/product/diamond/id/' . $id.'/type/'.Mage::registry("design_type");
            }

            return $url;
        }

        return Mage::getBaseUrl();
    }

    public function getSettingUrl($product) {
        if ($product && $id = $product->getId()) {

             if (Mage::helper('diamonds/config')->isEnableSeoLink()){
                $url = Mage::getBaseUrl() . $product->getUrlKey() . '.html';
             } else {
                 $url = Mage::getBaseUrl() . 'design/product/setting/id/' . $id.'/type/'.Mage::registry("design_type");
             }
            return $url;
        }

        return Mage::getBaseUrl();
    }

    public function getAddToCompareUrl($product) {
        if ($product && $id = $product->getId()) {
            $url = Mage::getBaseUrl() . 'design/ajax/addtocompare/id/' . $id;
            return $url;
        }

        return Mage::getBaseUrl();
    }

    public function getRemoveFromCompareUrl($product) {
        if ($product && $id = $product->getId()) {
            $url = Mage::getBaseUrl() . 'design/ajax/removefromcompare/id/' . $id;
            return $url;
        }

        return Mage::getBaseUrl();
    }

    public function getSearchResultUrl($query = null) {
        return $this->_getUrl('design/index/search', array(
                    'isRing' => $this->isRingPage(),
                    '_query' => array('q' => $query)
                ));
    }

    public function isRingPage() {
        $ringPages = array(
            array('diamonds', 'settings', 'index'),
            array('diamonds', 'product', 'setting')
        );

        $module = Mage::app()->getRequest()->getModuleName();
        $controller = Mage::app()->getRequest()->getControllerName();
        $action = Mage::app()->getRequest()->getActionName();

        foreach ($ringPages as $ringPage) {

            if ($ringPage[0] == $module
                    && $ringPage[1] == $controller
                    && $ringPage[2] == $action) {

                return true;
            }
        }

        return false;
    }

    public function getRingId($type="Ring") {

        $entityTypeId = Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId();
        $attributeSet = Mage::getResourceModel('eav/entity_attribute_set_collection')->setEntityTypeFilter($entityTypeId)->addFilter('attribute_set_name', $type);

        foreach ($attributeSet as $attribute) {

            $ringId = $attribute->getId();
        }

        return $ringId;
    }

    public function getLooseDiamondId() {

        $entityTypeId = Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId();
        $attributeSet = Mage::getResourceModel('eav/entity_attribute_set_collection')->setEntityTypeFilter($entityTypeId)->addFilter('attribute_set_name', 'Diamond');

        foreach ($attributeSet as $attribute) {

            $diamondId = $attribute->getId();
        }

        return $diamondId;
    }
    
    public function getRingDiamondIds() {

        $entityTypeId = Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId();
        $attributeSet = Mage::getResourceModel('eav/entity_attribute_set_collection');
        $attributeSet->setEntityTypeFilter($entityTypeId)
                ->addFieldToFilter('attribute_set_name',array('in' => array('Ring_diamond', 'Diamond')));

        foreach ($attributeSet as $attribute) {
            $RingDiamondIds[] = $attribute->getId();
        }

        return $RingDiamondIds;
    }

}