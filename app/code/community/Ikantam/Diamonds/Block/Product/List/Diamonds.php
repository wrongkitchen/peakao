<?php

class Ikantam_Diamonds_Block_Product_List_Diamonds extends Ikantam_Diamonds_Block_Product_List {

    //private $_attributeSet = null;
    //private $_attributeColor = null;

    public function __construct() {
        parent::__construct();
        //$this->setFancyColor(false);
    }

    public function getProductCollection() {
        $looseDiamondId = Mage::helper('diamonds')->getLooseDiamondId();

        $this->addFilterAttribute('attribute_set_id', $looseDiamondId)
                ->addFilterAttribute('type_id', array('eq' => 'simple'));

        $session = Mage::getModel("diamonds/session");
        if ($session->isRingSelected()) {
            $ring = $session->getSelectedRing();
            $shape = $ring->getRingMainstoneShape();
            $diamondShape = Mage::helper("diamonds")->convertShapeForDiamond($shape);
            $this->addFilterAttribute("diamond_shape", $diamondShape);
        }

        $query = Mage::getSingleton('core/session')->getDiamondSearchQuery();
        if ($query) {
            parent::getProductCollection()->addAttributeToFilter(
                    array(
                        array('attribute' => 'name', 'like' => "%$query%")
                    )
            );
        }

        return parent::getProductCollection();
    }

}