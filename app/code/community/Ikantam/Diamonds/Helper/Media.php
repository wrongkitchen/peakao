<?php

class Ikantam_Diamonds_Helper_Media extends Mage_Core_Helper_Abstract {

   public function getmedia($diamond,$setting=null,$sizew=null,$sizeh=null){
	
	   return Mage::getBlockSingleton("diamonds/media")->setdiamond($diamond)
	   ->setsetting($setting)->setsizew($sizew)->setsizeh($sizeh);
   }

}