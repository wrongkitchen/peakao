<?php

class Ikantam_Diamonds_Bracelets_AjaxController extends Mage_Core_Controller_Front_Action {

    private function _checkAjax() {
        if (!$this->getRequest()->isAjax()) {
            $this->_redirect('diamonds/');
            return false;
        }
        return true;
    }

    public function addtocompareAction() {
        if (!$this->_checkAjax())
            return;

        $id = (int) $this->getRequest()->getParam('id');
        $product = Mage::getModel('catalog/product')->load($id);
        if ($product) {
            /* Mage::getSingleton('catalog/product_compare_list')->addProduct($product); */
            Mage::getModel("diamonds/compare")->addDiamond($id);
        }

        $this->_addListReponse();
        return;
    }

    public function removefromcompareAction() {
        if (!$this->_checkAjax())
            return;

        $id = (int) $this->getRequest()->getParam('id');
        $product = Mage::getModel('catalog/product')->load($id);
        if ($product) {
            /*Mage::getSingleton('catalog/product_compare_list')->removeProduct($product);*/
            Mage::getModel("diamonds/compare")->removeDiamond($id);
        }
        $this->_addListReponse();
        return;
    }

    private function _addListReponse() {

        $compareList = $this->loadLayout()->getLayout()->getBlock('diamonds_comparasion_list');
        $response = $compareList->toHtml();
        $this->getResponse()->setBody($response);
        return;
    }

    public function refreshUrlRewriteAction() {

        $helper = new Ikantam_Diamonds_Bracelets_Helper_Data();
        $attributeSets = $helper->getRingDiamondIds();

        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection->addAttributeToFilter('type_id', Mage_Catalog_Model_Product_Type::TYPE_SIMPLE)
                ->addAttributeToFilter('attribute_set_id', array('in' => $attributeSets));
        $observer = new Ikantam_Diamonds_Bracelets_Model_Observer();
        $result = "";
        foreach ($collection as $product) {
            $observer->updateUrlRewrite($product);
            $result .= $product->getId() . " ";
        }

        $this->getResponse()->setBody($result);
    }

}