<?php

class Ikantam_Diamonds_Model_Compare {

    private $_coreSession;

    const COMPARE_LIST = 'diamonds_compare_list';

    public function __construct() {
        $this->_coreSession = Mage::getSingleton('core/session');
    }

    public function addDiamond($id) {

        $productIds = $this->_coreSession->getData(self::COMPARE_LIST);
        if (!is_array($productIds)) {
            $productIds = array();
        }
        if (in_array($id, $productIds)) {
            return;
        }

        $productIds[] = $id;
        $this->_coreSession->setData(self::COMPARE_LIST, $productIds);
    }

    public function getDiamondsCollection() {
        $productIds = $this->_coreSession->getData(self::COMPARE_LIST);
        $products = Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToSelect("*")
                ->addAttributeToFilter('entity_id', array('in' => $productIds));
        return $products;
    }

    public function removeDiamond($id) {
        $productIds = $this->_coreSession->getData(self::COMPARE_LIST);
        foreach($productIds as $key=>$productId){
            if ($productId==$id)
                unset ($productIds[$key]);
        }
        $this->_coreSession->setData(self::COMPARE_LIST, $productIds);
    }
    
    public function getProductIds(){
        $productIds = $this->_coreSession->getData(self::COMPARE_LIST);
        return $productIds;
    }

}