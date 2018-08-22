<?php


class Ikantam_Diamonds_Block_Product_Wishlist_Addtowishlist extends Mage_Core_Block_Template
{
	private $_product = null;
	
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('diamonds/product/wishlist/addtowishlist.phtml');
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
	
	public function isInWishlist()
	{
		$product = $this->getProduct();
		if($product){
			$item = Mage::getModel('wishlist/item')->load($product->getId(),'product_id');
	        if ($item->getId()) {
	            return true;
	        }		
		}
		
		return false;
		
	}
	
	public function getAddUrl()
	{
		$product = $this->getProduct();
		$wishlistUrl = $this->helper('wishlist')->getAddUrl($product);
		return $wishlistUrl;
	}
	
	public function getRemoveUrl()
	{
		$product = $this->getProduct();
		$wishlistUrl = $this->helper('wishlist')->getRemoveUrl($product);
		return $wishlistUrl;
	}
	
	
	
	
}