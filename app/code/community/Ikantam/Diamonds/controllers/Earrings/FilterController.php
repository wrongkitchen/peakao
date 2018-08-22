<?php

class Ikantam_Diamonds_Earrings_FilterController extends Mage_Core_Controller_Front_Action {
    /*
     * ajax filter products
     * 
     */

    public function diamondAction() {
        if ($this->_isAjax()) {

            /* @var $resultsBlock Mage_Core_Block_Template */
            $resultsBlock = $this->loadLayout()->getLayout()->getBlock('diamonds_filter_results');
            /* @var $productListBlock Ikantam_Diamonds_Earrings_Block_Product_List_Diamonds */
            $productListBlock = $resultsBlock->getChild('diamonds_search_product_list');
            $attributes = $this->getRequest()->getParam('attributes');

            if ($attributes) {
                foreach ($attributes as $code => $attribute) {
                    $value = $this->_prepareAttributeFilterCondition($attribute);

                    foreach ($value as $cond => $val) {
                        $productListBlock->addFilterAttribute($code, array($cond => $val));
                    }
                }
            }

            $this->getResponse()->setBody($resultsBlock->toHtml());
        } else {
            $this->getResponse()->setRedirect(Mage::getUrl('diamonds/'));
        }
    }

    public function ringAction() {

        if ($this->_isAjax()) {

            /* @var $resultsBlock Mage_Core_Block_Template */
            $resultsBlock = $this->loadLayout()->getLayout()->getBlock('ring_filter_results');

            /* @var $productListBlock Ikantam_Diamonds_Earrings_Block_Product_List_Rings */
            $productListBlock = $resultsBlock->getChild('ring_search_product_list');

            $attributes = $this->getRequest()->getParam('attributes');
            if ($attributes) {
                foreach ($attributes as $code => $attribute) {
                    $value = $this->_prepareAttributeFilterCondition($attribute);

                    foreach ($value as $cond => $val) {
                        $productListBlock->addFilterAttribute($code, array($cond => $val));
                    }
                }
            }
            $this->getResponse()->setBody($resultsBlock->toHtml());
        } else {
            $this->getResponse()->setRedirect(Mage::getUrl('diamonds/'));
        }
    }

    public function recentlyAction() {

        if ($this->_isAjax()) {

            /* @var $resultsBlock Mage_Core_Block_Template */
            $resultsBlock = $this->loadLayout()->getLayout()->getBlock('diamonds_recently_viewed');

            /* @var $productListBlock Ikantam_Diamonds_Earrings_Block_Product_List_Recently */
            $productListBlock = $resultsBlock->getChild('rv_product_list');

            $this->getResponse()->setBody($resultsBlock->toHtml());
        } else {
            $this->getResponse()->setRedirect(Mage::getUrl('diamonds/'));
        }
    }

    private function _isAjax() {

        $isAjax = $this->getRequest()->isAjax();
        return $isAjax;
    }

    private function _prepareAttributeFilterCondition($attribute) {
        $condition = array();
        if (!is_array($attribute)) {
            $condition['eq'] = $attribute;
            return $condition;
        }

        /* @var $helper Ikantam_Diamonds_Earrings_Helper_Data */
        $helper = Mage::helper('diamonds');
        foreach ($attribute as $sign => $value) {
            $cond = $helper->getConditionBySign($sign);
            if (!is_array($value)) {
                $value = floatval($value);
            }
            $condition[$cond] = $value;
        }
        return $condition;
    }

}