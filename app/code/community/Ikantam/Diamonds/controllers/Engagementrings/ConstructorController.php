<?php

class Ikantam_Diamonds_Engagementrings_ConstructorController extends Mage_Core_Controller_Front_Action {

    public function diamondAction() {

        $diamondId = (int) $this->getRequest()->getParam('diamond_id', null);
        $session = new Ikantam_Diamonds_Model_Session();

        $productModel = Mage::getModel('catalog/product')->load($diamondId);

        if ($productModel) {
            $session->setSelectedDiamond($productModel);
        }

        if ($session->isRingSelected()) {
						$this->_redirect('design/engagementrings_review/design/');
          //  $this->addtocartAction();
            return;
        }

        $this->_redirect("design/engagementrings_settings");
    }

    public function settingAction() {
        /* 23.08.2013 */
        $ringId = (int) $this->getRequest()->getParam('ring_id', null);
        $ringSize = (float) $this->getRequest()->getParam('size', null);

        $productModel = Mage::getModel('catalog/product')->load($ringId);
        $session = new Ikantam_Diamonds_Model_Session();

        if ($productModel && $ringSize) {

            $session->setSelectedRing($productModel);
            $session->setSelectedRingSize($ringSize);
            
        }
        
        /* End 23.08.2013 */
        
        if ($session->isDiamondSelected()) {
			$this->_redirect('design/engagementrings_review/design/');
           // $this->addtocartAction();
            return;
        }

        $this->_redirect("design/engagementrings_index");
    }

    public function addtocartAction() {

        $bundle = new Ikantam_Diamonds_Model_Bundle();
         $s = $this->getrequest()->getParam('s'); 
		   $d = $this->getrequest()->getParam('d'); 
        $session = Mage::getModel('diamonds/session');
        $ring =$s? Mage::getmodel('catalog/product')->load($s): $session->getSelectedRing();
        $diamond =$d? Mage::getmodel('catalog/product')->load($d): $session->getSelectedDiamond();

        // remove diamond from cart
        /* @var $cart Mage_Checkout_Model_Cart */
        /*$cart = Mage::getSingleton('checkout/cart');
        $quote = $cart->getQuote();
        if ($quote->getItemsQty()) {
            foreach ($quote->getAllItems() as $item) {
                if ($item->getProductId() == $diamond->getId()) {
                    $cart->removeItem($item->getId());
                }
            }
        }*/
        // adding bundle to cart
        if ($ring && $diamond) {
            if ($bundle->init($ring, $diamond)) {
                $bundle->addToCart();
            } else {
                $session->removeSelectedRing();
                $session->removeSelectedRingSize();
                Mage::getSingleton('core/session')->addWarning('Product is not enabled to add to cart');
                $this->_redirectReferer();
                return;
            }
            /*23.08.2013*/
            $session->removeSelectedRing();
            $session->removeSelectedRingSize();
            $session->removeSelectedDiamond();
            /*End 23.08.2013*/
            $this->_redirect('checkout/cart');
            return;
        } else {

            Mage::getSingleton('catalog/session')
                ->addWarning($this->__('Please select ring and settings'));
        }

        $this->_redirect('checkout/');
        return;
    }

    public function resetAction() {
        $session = Mage::getModel('diamonds/session');
        $session->removeSelectedRing();
        $session->removeSelectedDiamond();
        /*23.08.2013*/
        $session->removeSelectedRingSize();
        /*End 23.08.2013*/
        $this->_redirectReferer();
    }

}