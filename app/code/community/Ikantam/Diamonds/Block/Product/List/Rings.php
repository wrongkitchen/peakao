<?php

class Ikantam_Diamonds_Block_Product_List_Rings extends Ikantam_Diamonds_Block_Product_List {

    public function __construct() {
        parent::__construct();
	
      switch(Mage::registry("design_type")){
		  case "engagement-rings":
		  $ringId = Mage::helper('diamonds')->getRingId("Ring");
		  break;
		  case "diamonds":
		  $ringId = Mage::helper('diamonds')->getRingId("Ring");
		  break;
		  case "earrings":
		  	  $ringId = Mage::helper('diamonds')->getRingId("Earring");
		  break;
		  case "pendants":
		    $ringId = Mage::helper('diamonds')->getRingId("pendants");
		  break;
		  default:
		  break;
		  
	  }
        

        $this->addFilterAttribute('attribute_set_id', $ringId)
                ->addFilterAttribute('type_id', array('eq' => 'simple'));

        $session = Mage::getModel("diamonds/session");
        if ($session->isDiamondSelected()) {
            $diamond = $session->getSelectedDiamond();
            $shape = $diamond->getDiamondShape();
		
            $ringMainstoneShape = Mage::helper("diamonds")->convertShapeForRing($shape);
            $this->addFilterAttribute("ring_mainstone_shape", $ringMainstoneShape);
        }

        $query = Mage::getSingleton('core/session')->getDiamondSearchQuery();
        if ($query) {
            parent::getProductCollection()->addAttributeToFilter(
                    array(
                        array('attribute' => 'name', 'like' => "%$query%")
                    )
            );
        }
    }

}