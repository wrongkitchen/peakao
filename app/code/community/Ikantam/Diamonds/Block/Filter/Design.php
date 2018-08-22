<?php


class Ikantam_Diamonds_Block_Filter_Design extends Mage_Core_Block_Template
{
	private $_session;
	
	public function _construct()
	{
		parent::_construct();
		$this->_session = new Ikantam_Diamonds_Model_Session();		
	}
	
	public function isSelectedDiamond()
	{
		return $this->_session->isDiamondSelected();		
	}
	
	public function getSelectedDiamond()
	{
		return Mage::getModel('catalog/product')->load($this->_session->getSelectedDiamond()->getEntityId());
	}
	
	public function isSelectedSettings()
	{
		return $this->_session->isRingSelected();
	}
	
	public function getSelectedSettings()
	{
		return Mage::getModel('catalog/product')->load($this->_session->getSelectedRing()->getEntityId());
	}
	
	
	
}