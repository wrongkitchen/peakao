<?php

class Ikantam_Diamonds_Model_Bundle {

    private $_product = null;
    private $_cartParams = null;
   protected $_type ;
    public function __construct() {
        $bundleName = Mage::helper('diamonds/config')->getBundleName();
        
		
		$collectionBundle = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToFilter('type_id', array('eq' => 'bundle'));
        if (!empty($bundleName)) {
          //  $collectionBundle->addAttributeToFilter('name', array('eq' => $bundleName));
        } 
		
        $product = $collectionBundle->getFirstItem();
		
        $this->_product = Mage::getModel('catalog/product')->load($product->getId());
    }

	
    public function init($ring, $diamond,$qty,$type,$diff) {
		switch($type){
			case "diamonds" :
			 $setting = "Ring";
			 break;
			 case "engagement-rings" :
			 $setting = "Ring";
			 break;
			 case "pendants" :
			 $setting = "Pendant";
			 break;
			 case "earrings" :
			 $setting = "Earring";
			 break;
			 default:
			 $setting="Ring";
		}
        $ringOptionId = $this->_getOptionId($setting);

        $diamondOptionId = $this->_getOptionId('Diamond');
       
	    $this->_type = $type;
        if (!$ringOptionId || !$diamondOptionId) {
			
            throw new Exception("Bundle product options not founded");
        }

        $ringSelectionId = $this->_getSelectionId($ringOptionId, $ring->getId());
        $diamondSelectionId = $this->_getSelectionId($diamondOptionId, $diamond->getId());

        if (!$ringSelectionId) {
           $ringSelectionId = $this->addItem($setting,$ring);
			
        }
         if (!$diamondSelectionId) {
            $diamondSelectionId = $this->addItem("Diamond",$diamond);
        }
		$options =  array(
                $ringOptionId => $ringSelectionId,
                $diamondOptionId => array($diamondSelectionId)
            );
		if ($diff){
			
			$bundle_qty[$ringOptionId] =2;

	         if($diff->getid()== $diamond->getId()){
				$bundle_qty[$diamondOptionId]=2 ;
			    
			 }
			else{ 
			$diffSelectionId = $this->_getSelectionId($diamondOptionId, $diff->getId());
			  if (!$diamondSelectionId) {
            $diffSelectionId = $this->addItem("Diamond",$diff);
             }
			 $options[$diamondOptionId][] = $diffSelectionId;
			}
		}
        $this->_cartParams = array(
            'product' => $this->_product->getId(),
            'related_product' => null,
             'bundle_option' => $options,
            'qty' => $qty,
        );
       if ($bundle_qty) $this->_cartParams['bundle_option_qty'] =$bundle_qty;
	
        return true;
    }

    public function addToCart() {
        if (is_null($this->_cartParams)) {
            return false;
        }

        $cart = Mage::getSingleton('checkout/cart');
        try {
            /* 22.08.2013 */
            //$existingItems = array();

            $session = Mage::getModel('diamonds/session');

            /* $options = array('options' => array(
              3 => 'olaaaaaaaa',
              )
              );
              $this->_cartParams = array_merge($this->_cartParams, $options); */
            /* End 22.08.2013 */
            $cart->addProduct($this->_product, $this->_cartParams);
            $cart->save();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        Mage::getSingleton('checkout/session')->setCartWasUpdated(true);

        return true;
    }

    private function _getOptionId($title) {
        $options = $this->_product->getTypeInstance(true)->getOptions($this->_product);

        foreach ($options as $option) {

            if ($option->getDefaultTitle() === $title) {
                return $option->getId();
            }
        }
        return null;
    }

    private function _getSelectionId($optionId, $productId) {

        $selections = Mage::getResourceModel('bundle/selection_collection')
                ->setOptionIdsFilter(array($optionId));
        $selections->getSelect()
                ->where('selection.product_id = ?', $productId);

        return count($selections) ? $selections->getFirstItem()->getSelectionId() : null;
    }

    public function addItem($optionTitle, $product) {
        $optionId = $this->_getOptionId($optionTitle);
        $selectionId = $this->_getSelectionId($optionId, $product->getId());
        if (!$selectionId) {
            $selection = new Mage_Bundle_Model_Selection();
            $item = array(
                "option_id" => $optionId,
                "parent_product_id" => $this->_product->getId(),
                "product_id" => $product->getId(),
                "position" => '0',
                "is_default " => '0',
                "selection_price_type" => '0',
                "selection_price_value" => '0',
                "selection_qty" => '1',
                "selection_can_change_qty" => '1'
            );
            $selection->setData($item);
           Mage::register("product",$this->_product);
            $selection->save();
			
			return $selection->getid();
        }
    }

}