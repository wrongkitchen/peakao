<?php

class Ikantam_Diamonds_ConstructorController extends Mage_Core_Controller_Front_Action {

    public function diamondAction() {
         $type = $this->getRequest()->getParam('type');
        $diamondId = (int) $this->getRequest()->getParam('diamond_id', null);
        $session = new Ikantam_Diamonds_Model_Session();

        $productModel = Mage::getModel('catalog/product')->load($diamondId);

        if ($productModel) {
			if(Mage::getSingleton('core/session')->getEarringdiff()&&$session->isDiamondSelected()){
			Mage::getSingleton('core/session')->setDiamonddiff($productModel);	
			}
            else $session->setSelectedDiamond($productModel);
		    
			
        }

        if ($session->isRingSelected()) {
		      if(Mage::getSingleton('core/session')->getEarringdiff()&&!Mage::getSingleton('core/session')->getdiamonddiff()){
				$this->_redirect("design/diamond/index/diff/true/type/".$type);
			}
			else $this->_redirect("design/review/design/type/".$type);
                     
		  //  $this->addtocartAction();
            return;
        }

        $this->_redirect("diamonds/settings/index/type/".$type);
    }

    public function settingAction() {
        /* 23.08.2013 */$type = $this->getRequest()->getParam('type');
        $ringId = (int) $this->getRequest()->getParam('ring_id', null);
        $ringSize = (float) $this->getRequest()->getParam('size', null);
        $qty = (int) $this->getRequest()->getParam('qty', null);
		$diff = $this->getRequest()->getparam('diff');
        $productModel = Mage::getModel('catalog/product')->load($ringId);
        $session = new Ikantam_Diamonds_Model_Session();

        if ($productModel) {
            if($qty) Mage::getSingleton('core/session')->setEarringqty($qty);
			else Mage::getSingleton('core/session')->unsEarringqty();
            if ($diff) Mage::getSingleton('core/session')->setEarringdiff(true);
			else Mage::getSingleton('core/session')->unsEarringdiff();
			$session->setSelectedRing($productModel);
            if ($ringSize) $session->setSelectedRingSize($ringSize);
            
        }
        
        /* End 23.08.2013 */
        
        if ($session->isDiamondSelected()) {
			   if($diff){
				$this->_redirect("design/diamond/index/diff/true/type/".$type);
			}
			else $this->_redirect("design/review/design/type/".$type);
           // $this->addtocartAction();
            return;
        }

        $this->_redirect("design/diamond/index/type/".$type);
    }

    public function addtocartAction() {

        $bundle = new Ikantam_Diamonds_Model_Bundle();
        $s = $this->getrequest()->getParam('s'); 
		$d = $this->getrequest()->getParam('d'); 
        $session = Mage::getModel('diamonds/session');
        $ring =$s? Mage::getmodel('catalog/product')->load($s): $session->getSelectedRing();
        $diamond =$d? Mage::getmodel('catalog/product')->load($d): $session->getSelectedDiamond();
        $qty = Mage::getSingleton('core/session')->getEarringqty();
		if(Mage::getSingleton('core/session')->getEarringdiff()){
			$diamonddiff = Mage::getSingleton('core/session')->getDiamonddiff();
		}
		$type = $this->getRequest()->getparam("type");
		
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
		
            if ($bundle->init($ring, $diamond,$qty,$type,$diamonddiff)) {
               $bundle->addToCart();
				
            } else {
                $session->removeSelectedRing();
                $session->removeSelectedRingSize();
                Mage::getSingleton('core/session')->addWarning('Product is not enabled to add to cart');
                $this->_redirectReferer();
                return;
            }
            /*23.08.2013*/
			;
            $session->removeSelectedRing();
            $session->removeSelectedRingSize();
            $session->removeSelectedDiamond();
			Mage::getSingleton('core/session')->unsEarringdiff();
			Mage::getSingleton('core/session')->unsDiamonddiff();
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
		Mage::getSingleton('core/session')->unsEarringqty();
        Mage::getSingleton('core/session')->unsEarringdiff();
	    Mage::getSingleton('core/session')->unsDiamonddiff();
        $session->removeSelectedRing();
        $session->removeSelectedDiamond();
        /*23.08.2013*/
        $session->removeSelectedRingSize();
        /*End 23.08.2013*/
        $this->_redirectReferer();
    }

}