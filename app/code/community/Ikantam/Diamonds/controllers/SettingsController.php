<?php

class Ikantam_Diamonds_SettingsController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
	
			$type=$this->getRequest()->getParam("type");
		
		if($type){
			
			Mage::register("design_type",$type);
		}
		
        if (!$this->getRequest()->getParam('search')) {
            Mage::getSingleton('core/session')->unsDiamondSearchQuery();
        }

        $this->loadLayout();

        $this->renderLayout();
    }

}