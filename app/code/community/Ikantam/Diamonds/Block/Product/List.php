<?php



class Ikantam_Diamonds_Block_Product_List extends Mage_Catalog_Block_Product_List
{
	private $_filterAttributes;
	
	protected $_productCollection;
	
	public function __construct()
	{
		parent::__construct();
		$this->_initProductCollection();
		$this->setToolBarBlockName("toolbar");
	}
	
	public function getProductCollection()
    {
    	return $this->_productCollection;
    }
	
	private function _initProductCollection()
	{
		if (is_null($this->_productCollection)) {
			/* @var $collection Mage_Catalog_Model_Resource_Product_Collection */
			$collection = Mage::getResourceModel('catalog/product_collection');
			
			Mage::getModel('catalog/layer')->prepareProductCollection($collection);
			$collection->addStoreFilter();
			$this->_productCollection = $collection;
		}
		
	}
	
	public function addFiltercat( $cat ){
		$this->_productCollection
		->addCategoryFilter(Mage::getModel('catalog/category')->load($cat));
	}
	public function addFilterAttributes( $attributes )
	{
		foreach ($attributes as $attributeCode => $value){
			$this->addFilterAttribute($attributeCode, $value);
		}		
	}
	
	public function addFilterAttribute($attributeCode, $value)
	{
		if(is_array($value)){
			foreach ($value as $_sign => $_value){
				$this->_productCollection
					 ->addAttributeToFilter(
							 $attributeCode,
							 array($_sign => $_value)
				);
			}
		} else {
			$this->_productCollection
				 ->addAttributeToFilter($attributeCode, $value);
		}
		return $this;
	}
	
	
	public function getToolbarBlock()
	{
		
		$block = $this->getChild("toolbar");
		$block->setCollection($this->getProductCollection());
		return $block;
	}
        
       
	
}