<?php

class Ikantam_Diamonds_Engagementrings_QuickviewController extends Mage_Core_Controller_Front_Action {
   

      public function viewAction() {
		  $this->loadLayout();
         $result = $this->getLayout()
                 ->createBlock("diamonds/quickview")
                 ->setTemplate("design/ring/quickview.phtml")
                 ->toHtml();  
				   $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

}