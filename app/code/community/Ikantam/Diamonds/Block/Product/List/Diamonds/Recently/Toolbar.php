<?php


class Ikantam_Diamonds_Block_Product_List_Diamonds_Recently_Toolbar extends Mage_Catalog_Block_Product_List_Toolbar
{
	
	protected function _construct()
    {
    	parent::_construct();
    	$this->_availableMode =  array('grid' => $this->__('Grid'), 'list' =>  $this->__('List'), 'comparison' => $this->__('Comparison'));
    }
    
    private function _initAvailableOrder()
    {
    	$this->_availableOrder = array(
    			'carat' => $this->__('Carat'),
    			'clarity' => $this->__('Clarity'),
    			'cut' => $this->__('Cut'),
    			'price'	=> $this->__('Price')
    	);
    	 
    	$colorCode = Ikantam_Diamonds_Model_Config::LOOSE_COLOR;
    	if(Mage::registry('is_fancy')){
    		$colorCode = Ikantam_Diamonds_Model_Config::FANCY_COLOR;
    	}
    
    	$this->_availableOrder[$colorCode] = $this->__('Color');
    	 
    }
    
    public function getAvailableOrders()
    {
    	$this->_initAvailableOrder();
    	return $this->_availableOrder;
    }
	
	
}