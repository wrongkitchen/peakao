<?php

class Ikantam_Diamonds_Block_Product_List_Earrings extends Ikantam_Diamonds_Block_Product_List {

    public function __construct() {
        parent::__construct();

        $ringId = Mage::helper('diamonds/earring')->getEarringId();

        $this->addFilterAttribute('attribute_set_id', $ringId)
                ->addFilterAttribute('type_id', array('eq' => 'simple'));

        $session = Mage::getModel("diamonds/session");
        if ($session->isDiamondSelected()) {
            $diamond = $session->getSelectedDiamond();
            $shape = $diamond->getDiamondShape();
		
            $ringMainstoneShape = Mage::helper("diamonds/earring")->convertShapeForRing($shape);
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