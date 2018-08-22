<?php
class Ikantam_Diamonds_Diamonds_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		if(!$this->getRequest()->getParam('search')){
			Mage::getSingleton('core/session')->unsDiamondSearchQuery();
		}
		
		
		$this->loadLayout();
		/* @var $productList Ikantam_Diamonds_Diamonds_Block_Product_List_Diamonds */
		$productList = $this->getLayout()->getBlock('diamonds_search_product_list');
		
		//$isFancyColor = $this->getRequest()->getParam("is_fancy",false);
		//$productList->setFancyColor($isFancyColor);				
		//Mage::register('is_fancy', $isFancyColor);
		
		
		$this->renderLayout();

	}

    public function quickAction()
    {
        $this->loadLayout();
        $this->renderLayout();

    }

	public function searchAction()
	{
		
		$query = $this->getRequest()->getParam('q');
		if($query){
			Mage::getSingleton('core/session')->setDiamondSearchQuery($query);
			
			$resultSize = array();
			$diamonds = new Ikantam_Diamonds_Diamonds_Block_Product_List_Diamonds();
			$resultSize['diamonds'] = $diamonds->getProductCollection()->getSize();
			
			$rings = new Ikantam_Diamonds_Diamonds_Block_Product_List_Rings();
			$resultSize['rings'] = $rings->getProductCollection()->getSize();
			Mage::getSingleton('core/session')->setDiamondSearchSize($resultSize);
						
		} else {
			Mage::getSingleton('core/session')->unsDiamondSearchQuery();
		}
		
		
		if($this->getRequest()->getParam('isRing')){
			$this->_redirect('diamonds/settings', array( '_query' => array('search' => 1) ));
		} else {
			$this->_redirect('diamonds/', array( '_query' => array('search' => 1) ));			
		}
		 
	}


}