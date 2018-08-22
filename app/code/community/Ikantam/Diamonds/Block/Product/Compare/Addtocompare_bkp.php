<?php


class Ikantam_Diamonds_Block_Product_Compare_Addtocompare extends Mage_Core_Block_Template
{
	private $_product = null;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('diamonds/product/compare/addtocompare.phtml');
	}
	
	public function setProduct($product)
	{
		$this->_product = $product;
		return $this;
	}
	
	public function getProduct()
	{
		if(is_null($this->_product)){
			return Mage::registry('product');
		} else {
			return $this->_product;
		}
			
	}
	
	public function isComparing()
	{
		$product = $this->getProduct();
		if($product){
			/* @var $compareList Mage_Catalog_Model_Product_Compare_List */
			$item = Mage::getModel('catalog/product_compare_item');
	        $item->loadByProduct($product);
	        if ($item->getId()) {
	            return true;
	        }		
		}
		
		return false;
		
	}
	
	public function getAddUrl()
	{
		$product = $this->getProduct();
		$compareUrl = $this->helper('diamonds')->getAddToCompareUrl($product);
		return $compareUrl;
	}
	
	public function getRemoveUrl()
	{
		$product = $this->getProduct();
		$compareUrl = $this->helper('diamonds')->getRemoveFromCompareUrl($product);
		return $compareUrl;
	}
	
	
	
	
}