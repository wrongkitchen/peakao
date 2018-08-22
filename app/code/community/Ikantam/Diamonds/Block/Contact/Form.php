<?php


class Ikantam_Diamonds_Block_Contact_Form extends Mage_Core_Block_Template
{
	
	public function getFormAction()
	{
		$action = Mage::getUrl('contacts/index/post');
		return $action;
	}
	
	
	
	
}