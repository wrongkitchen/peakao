<?php


class Ikantam_Diamonds_Model_Recently {
	
	
	private $_coreSession;
	const RECENTLY_VIEWED = 'diamonds_recently_viewed';
	
	public function __construct()
	{
		$this->_coreSession = Mage::getSingleton('core/session');
	}
	
	public function addDiamond($id)
	{
		
		$productIds = $this->_coreSession->getData(self::RECENTLY_VIEWED);
		if(!is_array($productIds)){
			$productIds = array();
		}
		if(in_array($id, $productIds)){
			return;
		}
		
		$productIds[] = $id;
		$this->_coreSession->setData(self::RECENTLY_VIEWED, $productIds);
		
	}
	
	public function getDiamondsCollection()
	{
		$productIds = $this->_coreSession->getData(self::RECENTLY_VIEWED);
		$products = Mage::getModel('catalog/product')
						->getCollection()
						->addAttributeToSelect("*")
						->addAttributeToFilter('entity_id', array('in' => $productIds));
		return $products;
	}
	
	public function clearDiamonds()
	{
		$this->_coreSession->setData(self::RECENTLY_VIEWED, array());
	}
	
	
}