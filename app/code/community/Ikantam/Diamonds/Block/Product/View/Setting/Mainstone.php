<?php


class Ikantam_Diamonds_Block_Product_View_Setting_Mainstone extends Mage_Core_Block_Template
{
	
	public function isActive()
	{
		$session = Mage::getModel('diamonds/session');
		return $session->isDiamondSelected();
	}
	
	public function getDiamond()
	{
		$diamond = Mage::getModel('diamonds/session')->getSelectedDiamond();
		$diamond = mage::getModel('catalog/product')->load($diamond->getId());
		return $diamond;
	}
	
	
	
}