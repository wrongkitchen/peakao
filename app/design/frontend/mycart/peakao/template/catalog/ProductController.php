<?php
class Ikantam_Diamonds_ProductController extends Mage_Core_Controller_Front_Action
{
	public function viewreport($id){
		$product = Mage::getmodel("catalog/product")->load($id);
	   Mage::dispatchEvent('catalog_controller_product_view', array('product' => $product));
	}
	
    public function settingAction()
    {	
	    $id = $this->getRequest()->getParam('id');
		$this->viewreport($id);
    	$ring = Mage::getModel('catalog/product')->load($id);
    	$type=$this->getRequest()->getParam("type");
		if(!$type){
$attributeSetModel = Mage::getModel("eav/entity_attribute_set");
$attributeSetModel->load($ring->getAttributeSetId());
$attributeSetName  = $attributeSetModel->getAttributeSetName();

	$designtype = array('Ring'=>'engagement-rings','Earring'=>'earrings','Pendants'=>'pendants');	
	
	$currentUrl = Mage::helper('core/url')->getCurrentUrl();
	$this->_redirectUrl($currentUrl.$designtype[$attributeSetName]);
            			
		}
		Mage::register("design_type",$type);
    	
    	if($ring && Mage::helper('diamonds/set')->isRing($ring)||1){
    		Mage::register('product', $ring);
			Mage::register('current_product', $ring);
    	} else {
    		$this->_redirect('diamonds/');
    		return;
    	}
    	
    	// event
    	Mage::dispatchEvent('diamonds_ring_view', array('product_id' => $id));
    	
    	$this->loadLayout()->renderLayout();
		
    }
    public function designtype($product){

	}
    public function diamondAction()
    {
		
    	$type=$this->getRequest()->getParam("type");
		$id = $this->getRequest()->getParam('id');
		$diamond = Mage::getModel('catalog/product')->load($id);
		if(!$type){
	
	$currentUrl = Mage::helper('core/url')->getCurrentUrl();
	$this->_redirectUrl($currentUrl."diamonds");
            			
		}
		Mage::register("design_type",$type);
		
    	
		$this->viewreport($id);
    
    	if($diamond && Mage::helper('diamonds/set')->isDiamond($diamond)){
    		Mage::register('product', $diamond);
Mage::register('current_product', $diamond);
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