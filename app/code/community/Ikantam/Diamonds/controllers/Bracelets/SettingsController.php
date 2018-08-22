<?php

class Ikantam_Diamonds_Bracelets_SettingsController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        if (!$this->getRequest()->getParam('search')) {
            Mage::getSingleton('core/session')->unsDiamondSearchQuery();
        }

        $this->loadLayout();

        $this->renderLayout();
    }

}