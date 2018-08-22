<?php


class Ikantam_Diamonds_Block_Filter_Attribute_Shape extends Ikantam_Diamonds_Block_Filter_Attribute
{
	
	private $_defaultShape = array();
	
	/*public function _construct()
	{
		$shape = $this->getRequest()->getParam('shape');
		if($shape){
			$shape = strtolower($shape);
			$attrModel = Mage::getModel('catalog/product')
				->getResource()
				->getAttribute("shape");
			
			$attributeOptions = Mage::getResourceModel('eav/entity_attribute_option_collection')
				->setAttributeFilter($attrModel->getId())
				->setStoreFilter()
				->load();
			foreach($attributeOptions as $option){
				if(strtolower($option->getValue()) == $shape){
					$this->_defaultShape[] = $option->getId();
				}
			}
			
		}
		
		
	}*/
	

	/*public function getAttributeOptions( $attributeName )
	{
		$attrModel = Mage::getModel('catalog/product')
		->getResource()
		->getAttribute($attributeName);
		if(!$attrModel){
			return array();
		}
	
		$attrId = $attrModel->getId();

		$attributeOptions = Mage::getResourceModel('eav/entity_attribute_option_collection')
			->setOrder('sort_order','desc')
			->setAttributeFilter($attrId)
			->setStoreFilter()
			->load();
		return $attributeOptions;
	
	}*/
	
	
	
	/*public function isDefault($shapeId)
	{	
		return in_array($shapeId, $this->_defaultShape);	
	}*/
	
	
	
	
}