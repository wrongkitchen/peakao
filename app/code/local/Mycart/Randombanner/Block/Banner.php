<?php

class Mycart_Randombanner_Block_Banner extends Mage_Core_Block_Template {

    public function __construct() {
       $this->settemplate("randombanner/banner.phtml");

        return parent::__construct();
    }

    public function _prepareLayout() {
        return parent::_prepareLayout();
    }
    
	public function fetchbanner(){
		$banner= Mage::getmodel("randombanner/banner")->getcollection()->addfieldtofilter("name",array("eq"=>$this->getname()));
	     
		return $banner;
	}
 
}
