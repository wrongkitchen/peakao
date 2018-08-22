<?php


class Ikantam_Diamonds_Helper_Set extends Mage_Core_Helper_Abstract
{
	
	public function isLooseDiamond($product)
	{
		$diamondsSetNames = array('Diamond');
		$attributeSetModel = Mage::getModel("eav/entity_attribute_set");
		$attributeSetModel->load($product->getAttributeSetId());
		$attributeSetName = $attributeSetModel->getAttributeSetName();
		
		if(in_array($attributeSetName, $diamondsSetNames)){
			return true;
		}
		return false;
		
	}
	
	public function isDiamond($product)
	{
		$diamondsSetNames = array('Diamond');
		$attributeSetModel = Mage::getModel("eav/entity_attribute_set");
		$attributeSetModel->load($product->getAttributeSetId());
		$attributeSetName = $attributeSetModel->getAttributeSetName();

		if(in_array($attributeSetName, $diamondsSetNames)){
		
			return true;
		}
		return false;
		
	}
	
	public function isRing($product)
	{
		$ringsSetNames = array('Ring', 'Ring');
		$attributeSetModel = Mage::getModel("eav/entity_attribute_set");
		$attributeSetModel->load($product->getAttributeSetId());
		$attributeSetName = $attributeSetModel->getAttributeSetName();
       
		if(in_array($attributeSetName, $ringsSetNames)){
	
			return true;
		}
		
		return false;
	
	}
	
	/*public function isRingSet($product)
	{
		$ringsSetNames = array('Ring');
		$attributeSetModel = Mage::getModel("eav/entity_attribute_set");
		$attributeSetModel->load($product->getAttributeSetId());
		$attributeSetName = $attributeSetModel->getAttributeSetName();
       
		if(in_array($attributeSetName, $ringsSetNames)){
		
			return true;
		}
	
		return false;
	}*/
	
}