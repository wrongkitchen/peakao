<?php

class Ikantam_Diamonds_Diamonds_QuickviewController extends Mage_Core_Controller_Front_Action {
   

      public function viewAction() {
		  $this->loadLayout();
         $result = $this->getLayout()
                 ->createBlock("diamonds/quickview")
                 ->setTemplate("diamonds/quickview.phtml")
                 ->toHtml();  
				   $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

}