<?php



class Ikantam_Diamonds_Block_Filter_Results extends Mage_Catalog_Block_Product_List
{
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function getResultsCollection()
	{
		
		$productModel = Mage::getModel('catalog/product');
		$collection = $productModel->getCollection();
		
		return $collection;		
	}
	
	
}