<?php

class Ikantam_Diamonds_Model_Observer {

    public function checkoutCartProductAddAfter(Varien_Event_Observer $observer) {
        /* @var $item Mage_Sales_Model_Quote_Item */
        $item = $observer->getEvent()->getQuoteItem();
        $product = Mage::getModel('catalog/product')->load($item->getProductId());
        $helper = new Ikantam_Diamonds_Helper_Set();
        if ($helper->isRing($product)) {
            $ringSize = Mage::getModel('core/session')->getRingSize();
            if ($ringSize) {
                $item->addOption(array(
                    "item_id" => $item->getId(),
                    "product_id" => $item->getProduct()->getId(),
                    "code" => "ring_size",
                    "value" => serialize($ringSize)
                ));
                $item->save();
            }
        }


        //Mage::getModel('core/session')->unsRingSize();
    }

    /* end add custom option */



    /* public function salesConvertQuoteItemToOrderItem(Varien_Event_Observer $observer)
      {
      $quoteItem = $observer->getItem();
      echo $quoteItem->getId();
      die();
      $additionalOptions = $quoteItem->getOptionByCode('ring_size');
      if ($additionalOptions) {
      $orderItem = $observer->getOrderItem();
      $options = $orderItem->getProductOptions();
      $options['ring_size'] = unserialize($additionalOptions->getValue());
      $orderItem->setProductOptions($options);
      }
      } */


    /* 22.08.2013 */

    public function updateRingSize($observer) {
        $orderIds = $observer->getEvent()->getOrderIds();
        foreach ($orderIds as $orderId) {
            $order = Mage::getModel('sales/order')->load($orderId);

            foreach ($order->getAllItems() as $item) {
                $qiId = $item->getQuoteItemId();

                $quoteItem = Mage::getModel('sales/quote_item')->load($qiId);

                $optionCollection = Mage::getModel('sales/quote_item_option')
                        ->getCollection()
                        ->addItemFilter($quoteItem)
                        ->addFilter('code', 'ring_size');

                foreach ($optionCollection as $oo) {
                    $productOptions = $item->getProductOptions();
                    $productOptions['ring_size'] = $oo->getValue();
                    $item->setProductOptions($productOptions)->save();
                }
            }
        }
    }

    /* 22.08.2013 */

    public function productView(Varien_Event_Observer $observer) {

        $id = $observer->getEvent()->getProductId();
        $recentlyModel = Mage::getModel("diamonds/recently")->addDiamond($id);
    }

    /* public function productAddToCartAfter(Varien_Event_Observer $observser){

      $product = $observser->getEvent()->getProduct();
      $product = Mage::getModel('catalog/product')->load($product->getId());
      $helper = new Ikantam_Diamonds_Helper_Set();
      if ($helper->isDiamond($product)) {

      $session = new Ikantam_Diamonds_Model_Session();
      if ($session->isDiamondSelected()) {
      return;
      }
      $session->setSelectedDiamond($product);
      }
      } */

    /**
     * 
     * @param Varien_Event_Observer $observer
     */
    /* public function addCustomOptions(Varien_Event_Observer $observer) {
      $product = $observer->getEvent()->getProduct();

      if ($this->_isOptionExist($product, 'Size')) {
      return;
      }
     */

    /** @var $helper Ikantam_Diamonds_Helper_Set */
    /*      $helper = Mage::helper('diamonds/set');
      if ($helper->isRingSet($product)) {

      $config = new Ikantam_Diamonds_Model_Config();
      $sizeOptionData = $config->getSizeOptionData();

      $this->_addCustomOption($product, $sizeOptionData);
      }
      }

      private function _isOptionExist($product, $title) {
      $options = $product->getOptions();

      foreach ($options as $option) {
      if ($option->getTitle() === 'Size') {
      return true;
      }
      }

      return false;
      }

      private function _addCustomOption($product, $optionData) {
      $product->setHasOptions(1);

      $opt = Mage::getModel('catalog/product_option');
      $opt->setProduct($product);
      $opt->addOption($optionData);
      $opt->saveOptions();
      } */

    /* 22.08.2013 */

    public function addToBundle(Varien_Event_Observer $observer) {
        $product = $observer->getEvent()->getProduct();
        $bundle = new Ikantam_Diamonds_Model_Bundle();
        $helper = new Ikantam_Diamonds_Helper_Set();

        if ($helper->isDiamond($product)) {
            $bundle->addItem('Diamond', $product);
        };

        if ($helper->isRing($product) && $product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE) {
            $childProducts = Mage::getModel('catalog/product_type_configurable')
                    ->getUsedProducts(null, $product);
            foreach ($childProducts as $child) {
                $childProduct = Mage::getModel('catalog/product')->load($child->getId());
                $bundle->addItem('Ring', $childProduct);
            }
            /* $bundle->addItem('Ring', $product); */
        };
    }

    /* End 22.08.2013 */

    /*public function updateUrl(Varien_Event_Observer $observer) {
        if (Mage::helper('diamonds/config')->isEnableSeoLink()) {
            $product = $observer->getEvent()->getProduct();
            $this->updateUrlRewrite($product);
        }
    }

    public function updateUrlRewrite($product) {
        $helper = new Ikantam_Diamonds_Helper_Set();


        $id = $product->getId();
        $_product = Mage::getModel('catalog/product')->load($id);

        $idPathes = array(
            'jewelry_' . $id => $_product->getUrlKey() . '.html',
            'jewelry_catalog_' . $id => 'catalog/product/view/id/' . $id
        );

        $rewrite = Mage::getModel('core/url_rewrite');

        if ($helper->isDiamond($product) || $helper->isRing($product)) {
            foreach ($idPathes as $idPath => $requestPath) {
                $rewrite = Mage::getModel('core/url_rewrite');
                //remove old

                $rewrites = $rewrite->getCollection()
                        ->addFieldToFilter('request_path', $requestPath)
                        ->addFieldToFilter('id_path', array('neq' => $idPath));
                if ($rewrites) {
                    foreach ($rewrites as $rewrite) {
                        $rewrite->load($requestPath, 'request_path')->delete();
                    }
                }

                $rewrite = Mage::getModel('core/url_rewrite');
                $rewrite->setIsSystem(0)->setOptions('');
                //add new
                if (!$rewrite->load($idPath, 'id_path')->getId()) {
                    $rewrite->setIdPath($idPath);

                    if ($helper->isDiamond($product))
                        $rewrite->setTargetPath('diamonds/product/diamond/id/' . $id);
                    if ($helper->isRing($product))
                        $rewrite->setTargetPath('diamonds/product/setting/id/' . $id);
                }
                if ($requestPath == $idPathes['jewelry_' . $id])
                    $rewrite->setRequestPath($requestPath);

                if ($requestPath == $idPathes['jewelry_catalog_' . $id])
                    $rewrite->setRequestPath($requestPath);

                $rewrite->save();
            }
        }
    }*/

}