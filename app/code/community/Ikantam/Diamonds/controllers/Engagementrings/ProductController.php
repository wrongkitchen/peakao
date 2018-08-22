<?php
class Ikantam_Diamonds_Engagementrings_ProductController extends Mage_Core_Controller_Front_Action
{
	
	
    public function settingAction()
    {	
    	
    	$id = $this->getRequest()->getParam('id');
    	$ring = Mage::getModel('catalog/product')->load($id);
    	if($ring && Mage::helper('diamonds/set')->isRing($ring)){
    		Mage::register('product', $ring);
    	} else {
    		$this->_redirect('diamonds/');
    		return;
    	}
    	
    	// event
    	Mage::dispatchEvent('diamonds_ring_view', array('product_id' => $id));
    	
    	$this->loadLayout()->renderLayout();
		
    }
    
    public function diamondAction()
    {
    
    	$id = $this->getRequest()->getParam('id');
    	$diamond = Mage::getModel('catalog/product')->load($id);
    	if($diamond && Mage::helper('diamonds/set')->isDiamond($diamond)){
    		Mage::register('product', $diamond);
    	} else {
    		$this->_redirect('diamonds/');    
    		return;		
    	}
    	
    	// event
    	Mage::dispatchEvent('diamonds_diamond_view', array('product_id' => $id));
    	
    	$this->loadLayout()->renderLayout();   	
    	
    	
    }
    
    public function addtocartAction()
    {
        if (Mage::helper('diamonds/config')->isAllowAddRingToCart()){
            $size = $this->getRequest()->getParam('size');
            $productId = $this->getRequest()->getParam('product');
            if ($size && $productId){
                Mage::getModel('core/session')->setRingSize($size);
                $_product = Mage::getModel('catalog/product')->load($productId);
                $this->_redirectUrl((string)Mage::helper('checkout/cart')->getAddUrl($_product));
                
                /*'checkout/cart/add/product?' . $productId . '/'*/
            }
        }
    }
}