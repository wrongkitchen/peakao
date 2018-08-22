<?php

class Ikantam_Diamonds_ReviewController extends Mage_Core_Controller_Front_Action {

    public function designAction() {

        	$type=$this->getRequest()->getParam("type");
		if($type){
			Mage::register("design_type",$type);
		}
		
          	$this->loadLayout()->renderLayout();
    }


}