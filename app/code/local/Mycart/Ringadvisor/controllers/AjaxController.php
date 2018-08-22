<?php
class Mycart_Ringadvisor_AjaxController extends Mage_Core_Controller_Front_Action
{
	protected $_diamondset_id;
	
	protected $_settingset_id;
	
	protected function _construct(){
		$this->_diamondset_id = Mage::getModel('eav/entity_attribute_set')
			->load('Diamond', 'attribute_set_name')
		   ->getAttributeSetId();
		
		$this->_settingset_id = Mage::getModel('eav/entity_attribute_set')
			->load('Ring', 'attribute_set_name')
		   ->getAttributeSetId();
		   parent::_construct();
		
	}
	
    protected function filterdiamond($settings , $shape ,$budget){
			$diamonds =Mage::getmodel("catalog/product")->getcollection()
		    ->addAttributeToFilter('attribute_set_id',$this->_diamondset_id)
			->addattributetoselect("diamond_shape")
			->addattributetoselect("price");
			$shapes = array();
		if($shape){
           $shapes = explode(",",$shape);			
			foreach ($shapes as $k=>$v){
				$shapes[$k] = $this->getoptionid("diamond_shape",$v);
			}		
		}
	
		if($settings)
		{
	    $shapering =  array();
		$ringshapes = array_unique($settings->getColumnValues("ring_mainstone_shape"));
			foreach($ringshapes as $k){
				 $shapering[] = Mage::helper("diamonds")->convertShapeForDiamond($k);
			}
		}

		if ($settings || $shape){
		 if(!$shape) $shapes = $shapering;
         else if (!$shapering) {}		 
	      else $shapes = array_intersect($shapes,$shapering);
           
		 $diamonds->addfieldtofilter("diamond_shape",array("in"=>$shapes));	
		}
		
		if($budget){
		$baseCurrencyCode = Mage::app()->getStore()->getBaseCurrencyCode(); 
       $currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode(); 
		$budget = explode(",",$budget);
		
		$minprice = Mage::helper('directory')
		->currencyConvert(str_replace($currentCurrencyCode,"",$budget[0]), $baseCurrencyCode, $currentCurrencyCode); 
		$maxprice = Mage::helper('directory')
		->currencyConvert(str_replace($currentCurrencyCode,"",$budget[1]), $baseCurrencyCode, $currentCurrencyCode); 

       $diamonds->addfieldtofilter("price",array('from'=>$minprice,'to'=>$maxprice));
		
		}
    return $diamonds;		
	}
	protected function getoptionid($code,$value){
		   $attrModel = Mage::getModel('catalog/product')
                ->getResource()
                ->getAttribute($code);

        $attributeOptions = Mage::getResourceModel('eav/entity_attribute_option_collection')
                ->setAttributeFilter($attrModel->getId())
                ->setStoreFilter(0)
                ->load();
        foreach ($attributeOptions as $option) {
   
            if ($option->getValue() == $value) {
                return $option->getId();
            }
        }
	}
	
	  protected function filtersetting($diamonds , $metal, $style){
		
		$setting =Mage::getmodel("catalog/product")->getcollection()
		  ->addAttributeToFilter('attribute_set_id',$this->_settingset_id)
		->addattributetoselect("ring_style")
		->addattributetoselect("ring_color")
		->addattributetoselect("ring_mainstone_shape")
		   ->addfieldToFilter('type_id', array('eq' => 'simple'));
		if($metal){
           $metal = explode(",",$metal);

			foreach ($metal as $k=>$v){
				$metal[$k] = $this->getoptionid("ring_color",$v);
			}		
			$setting->addfieldtofilter('ring_color',array("in"=>$metal));
		}
		if($style){
           $style = explode(",",$style);
		   foreach ($style as $k=>$v){
				$style[$k] = $this->getoptionid("ring_style",$v);
			}	
           $setting->addfieldtofilter('ring_style',array("in"=>$style));
		   
		}
		if($diamonds)
		{
       $shapes = array();
		$diamondshapes = array_unique($diamonds->getColumnValues("diamond_shape"));
			foreach($diamondshapes as $k){
				$shapes[] = Mage::helper("diamonds")->convertShapeForRing($k);
			}

		$setting->addfieldtofilter('ring_mainstone_shape',array("in"=>$shapes));	
		}
	
		 return $setting;
          
		}		
	protected function filterbudget($budget,$diamonds){
	
		if(!$diamonds){
		$diamonds =Mage::getmodel("catalog/product")->getcollection()
			    ->addAttributeToFilter('attribute_set_id',$this->_diamondset_id)
				->addattributetoselect('price')
				->addattributetoselect('diamond_shape');
		}
	   
		
		$baseCurrencyCode = Mage::app()->getStore()->getBaseCurrencyCode(); 
       $currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode(); 
		$budget = explode(",",$budget);
		
		$minprice = Mage::helper('directory')
		->currencyConvert($budget[0], $baseCurrencyCode, $currentCurrencyCode); 
		$maxprice = Mage::helper('directory')
		->currencyConvert($budget[1], $baseCurrencyCode, $currentCurrencyCode); 

	return $diamonds->addfieldtofilter("price",array('from'=>$minprice,'to'=>$maxprice));
	
		
	}
	

	protected function getattrfromresult($diamonds,$setting){
		if($diamonds&&$diamonds->getSize()>0){
			
		$attr = array();
		$attr["shape"] =array_unique( $diamonds->getColumnValues("diamond_shape"));
		foreach ($attr["shape"] as $k =>$v){
		       if (is_numeric($v)) {
				$attributeOptions = Mage::getResourceModel('eav/entity_attribute_option_collection')
						->addFieldToFilter("main_table.option_id", $v)
						->setStoreFilter(0)
						->load();

				if (!$attributeOptions) {
					return null;
				}

				$attr["shape"][$k] = $attributeOptions->getFirstItem()->getValue();
			  }
		}
	
		$attr["budget"] =array(
		intval($diamonds ->setOrder('price', 'ASC')->getFirstItem()->getPrice()),
		intval($diamonds->getLastItem()->getprice()));
		}
		if ($setting&&$setting->getSize()>0 ){

		$metal =array_unique( $setting->getColumnValues("ring_color"));
		
		$attr["metal"] =array();
		foreach ($metal as $k =>$v){
		       if (is_numeric($v)) {
				$attributeOptions = Mage::getResourceModel('eav/entity_attribute_option_collection')
						->addFieldToFilter("main_table.option_id", $v)
						->setStoreFilter(0)
						->load();

			
            if ($attributeOptions) {
				$attr["metal"][] = $attributeOptions->getFirstItem()->getValue();
			  }
			  }
		}

        $attr["ring-style"] =array_unique( $setting->getColumnValues("ring_style"));	
		foreach ($attr["ring-style"] as $k =>$v){
		       if (is_numeric($v)) {
				$attributeOptions = Mage::getResourceModel('eav/entity_attribute_option_collection')
						->addFieldToFilter("main_table.option_id", $v)
						->setStoreFilter(0)
						->load();

				if ($attributeOptions) {
				$attr["ring-style"][$k] = $attributeOptions->getFirstItem()->getValue();
				}
				
			  }
		}
	  }
	  return $attr;
	}
	public function styleAction(){
		$attr = $this->getrequest()->getparam("attr");
		if($attr["shape"]||$attr["budget"]){
			 $diamonds = $this->filterdiamond(null,$attr["shape"],$attr["budget"]);
			if($diamonds){
		     $settings =  $this->filtersetting($diamonds,$attr["metal"],$attr["ring-style"]);	
		     }	
		}
		else if($attr["metal"]||$attr["ring-style"]) {
		 $settings = $this->filtersetting(null,$attr["metal"],$attr["ring-style"]);			 
		if($settings){
		 $diamonds = $this->filterdiamond($settings);	
		}		
		}

		
		$attrs = $this->getattrfromresult($diamonds,$settings);
		if($diamonds) $attrs["diamond"]= $diamonds->getAllIds();
		if($settings) $attrs["setting"]= $settings->getAllIds();
		if($attrs["shape"]) $attrs["shape"] =array_values($attrs["shape"] ) ;
		if($attrs["ring-style"]) $attrs["ring-style"] =array_values($attrs["ring-style"] ) ;
		if($attrs["metal"]) $attrs["metal"] =array_values($attrs["metal"] ) ;
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($attrs));
		return;
	}
	protected function getoptionorderid($code){
	    $attrModel = Mage::getModel('catalog/product')
                ->getResource()
                ->getAttribute($code);
        $attributeOptions = Mage::getResourceModel('eav/entity_attribute_option_collection')
                ->setAttributeFilter($attrModel->getId())
                ->setStoreFilter(0)
				
				->setOrder("sort_order","DESC")
				
                ->load();
		return array_reverse($attributeOptions->getColumnValues("option_id"));
	}
	
	protected function caratfilter($ids,$cut,$clarity,$color){
		$diamonds =Mage::getmodel("catalog/product")->getcollection()
		    ->addAttributeToFilter('attribute_set_id',$this->_diamondset_id)
           ->addattributetoselect("carat");
		if($ids) $diamonds->addfieldToFilter("entity_id",array("in"=>$ids));
		
		
		if($cut) {
			$options = $this->getoptionorderid("cut");
	
			$diamonds->addattributetoselect("cut");
            $cut =explode(",",$cut);
	
			for($i=$cut[0];$i<=$cut[1];$i++) {$cutmap[] = $options[$i-1];}

			  $diamonds->addfieldToFilter("cut",array("in"=>$cutmap));
			}
		if($clarity){
			$options = $this->getoptionorderid("clarity");
			$diamonds->addattributetoselect("clarity");
            $clarity =explode(",",$clarity);
	
			for($i=$clarity[0];$i<=$clarity[1];$i++) {$claritymap[] = $options[$i-1];}
			  $diamonds->addfieldToFilter("clarity",array("in"=>$claritymap));
			}
		if($color) {
			$options = $this->getoptionorderid("color_loose");
			$diamonds->addattributetoselect("color_loose");
            $color =explode(",",$color);
	
			for($i=$color[0];$i<=$color[1];$i++) {$colormap[] = $options[$i-1];}

			  $diamonds->addfieldToFilter("color_loose",array("in"=>$colormap));
			}
		 
		return $diamonds;
	}
	
	public function caratAction(){
	   $diamonds = $this->getrequest()->getparam("diamonds");
	   $attr = $this->getrequest()->getparam("attr");
	  

	   $diamonds= $this->caratfilter($diamonds,$attr["cut"],$attr["clarity"],$attr["color"]); 
	 $carat = $diamonds ->setOrder("carat","Desc")->getFirstItem()->getcarat();
       $result["diamond"] = $diamonds->getAllIds();
	   $result["carat"] =  number_format((float)$carat, 2, '.', '');
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
	}
	
	public function recommendAction(){
		$diamondids = $this->getrequest()->getparam("diamonds");
		$settingids = $this->getrequest()->getparam("settings");
        if($diamondids)
		{ 
			$diamonds =Mage::getmodel("catalog/product")->getcollection()
		    ->addAttributeToFilter('attribute_set_id',$this->_diamondset_id)
			->addattributetoselect("diamond_shape")
			->addfieldtofilter("entity_id",array("in"=>$diamondids));
			$settings = $this->filtersetting($diamonds);
		}
		$allsids = $settings->getAllIds();
		$settingids = array_intersect($allsids,$settingids);
		$result = $this->getlayout()->createblock("ringadvisor/recommend")
		->settemplate("advisor/recommend.phtml")->setsetting($settingids)
		->setdiamond($diamondids)->setalls($allsids);
		echo $result->tohtml();
	  }
	public function recshowAction(){
		$d = $this->getrequest()->getparam("d");
		$s = $this->getrequest()->getparam("s");
		$result = $this->getlayout()->createblock("core/template")
		->settemplate("advisor/recshow.phtml")->sets($s)->setd($d);
		if($this->getrequest()->getparam("update")){
			$res = array();
			$res["show"] = $result->tohtml();
			$res["update"] = '<li class="'.'active"
data-d="'.$d.'"
data-s="'.$s .'">
<div class="rec_cusor"><div class="arrow"></div></div>
<a
href="javascript:void(0)">
<img alt="" 
src="'.Mage::helper('catalog/image')->init(Mage::getmodel('catalog/product')->load($s) , 'small_image')->resize(110, 80) .'" />
</a></li>';
      $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($res));
		return;
		}
	    echo $result->tohtml();
	}
	public function adjustAction(){
			$type = $this->getrequest()->getparam("type");
			$dids = explode(",",$this->getrequest()->getparam("d"));
		$sids = explode(",",$this->getrequest()->getparam("alls"));
		switch($type)
		{
			case "metal":
			if ($sids){
			$settings =Mage::getmodel("catalog/product")->getcollection()
			->addattributetoselect("ring_metal")
			->addfieldtofilter("entity_id",array("in"=>$sids));
			$metal= array();
			foreach($settings as $s ){
				$m = $s ->getring_metal();
				$attributeOptions = Mage::getResourceModel('eav/entity_attribute_option_collection')
						->addFieldToFilter("main_table.option_id", $m)
						->setStoreFilter()
						->load();
				$metal[$s->getid()]= $attributeOptions->getFirstItem()->getValue();
			}
		    $metal = array_unique($metal);
			
			 $result = $this->getlayout()->createblock("core/template")
		->settemplate("advisor/adjust/metal.phtml")->setm($metal);
	    echo $result->tohtml();
			}
			break;
			case "diamond":
				if ($dids){			
			 $result = $this->getlayout()->createblock("core/template")
		     ->settemplate("advisor/adjust/diamond.phtml")->setd($dids);
	         echo $result->tohtml();
			}
			break;
		}
	}
}