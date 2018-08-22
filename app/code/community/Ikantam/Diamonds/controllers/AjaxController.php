<?php

class Ikantam_Diamonds_AjaxController extends Mage_Core_Controller_Front_Action {

    private function _checkAjax() {
        if (!$this->getRequest()->isAjax()) {
            $this->_redirect('diamonds/');
            return false;
        }
        return true;
    }
	public function reviewAction(){
		$pro =$this->getRequest()->getparam('id');
		$flag =$this->getRequest()->getparam('flag');
			if(!Mage::registry("product"))
		Mage::register("product",Mage::getModel('catalog/product')->load($pro));
	
		echo '
		<div class="compaire-diamond-overlay">
				<div class="outer-div">
			   <div class="compaire-diamond">
			<a href="javascript:void(0);" class="close-popup close-compaire"><img src="'.Mage::getDesign()->getskinurl("images").'/popup-close.png" alt="close"></a>
		'. $this->getlayout()->createblock("review/product_view_list")->settemplate("review/reviewpop.phtml")->setflag($flag)->tohtml().'
		</div>

			</div>
		</div>	
		<script type="text/javascript">
		 jQuery(".compaire-diamond-overlay,.close-popup").click(function(){
			jQuery(".compaire-diamond-overlay").hide(); 
		 })
		 jQuery(".compaire-diamond").click(function(e){
			e.stopPropagation();
		 })
		</script>
		';
		
	}
    public function sizeupdateAction(){
		$id = $this->getRequest()->getParam('item');
		$item = Mage::getModel("sales/quote_item")->load($id);
			$flag=0;	
        $options = Mage::getResourceModel('sales/quote_item_option_collection');
		$options->addItemFilter($item->getId());
		foreach ($options as $option) {
			var_dump($option->getdata());echo"<br>";
			if ($option->getcode()=="ring_size" && $option->getvalue())
			$flag=1;
		 if($option->getcode()=="ring_size")
	      $option->setvalue($this->getrequest()->getparam("size"))->save();
          $flag=0;	  
	}
		
		if ($flag==0){
			
			$item->addOption(
                array(
                     'code'  => 'ring_size',
                     'value' => "7",
                )
            );
			$item->save();
		}
     //$infoArr = unserialize($info->getValue());

		
	}
	
    public function addtocompareAction() {
        if (!$this->_checkAjax())
            return;

        $id = (int) $this->getRequest()->getParam('id');
        $product = Mage::getModel('catalog/product')->load($id);
        if ($product) {
            /* Mage::getSingleton('catalog/product_compare_list')->addProduct($product); */
            Mage::getModel("diamonds/compare")->addDiamond($id);
        }

        $this->_addListReponse();
        return;
    }

    public function removefromcompareAction() {
        if (!$this->_checkAjax())
            return;

        $id = (int) $this->getRequest()->getParam('id');
        $product = Mage::getModel('catalog/product')->load($id);
        if ($product) {
            /*Mage::getSingleton('catalog/product_compare_list')->removeProduct($product);*/
            Mage::getModel("diamonds/compare")->removeDiamond($id);
        }
        $this->_addListReponse();
        return;
    }

    private function _addListReponse() {

        $compareList = $this->loadLayout()->getLayout()->getBlock('diamonds_comparasion_list');
        $response = $compareList->toHtml();
        $this->getResponse()->setBody($response);
        return;
    }

    public function refreshUrlRewriteAction() {

        $helper = new Ikantam_Diamonds_Engagementrings_Helper_Data();
        $attributeSets = $helper->getRingDiamondIds();

        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection->addAttributeToFilter('type_id', Mage_Catalog_Model_Product_Type::TYPE_SIMPLE)
                ->addAttributeToFilter('attribute_set_id', array('in' => $attributeSets));
        $observer = new Ikantam_Diamonds_Engagementrings_Model_Observer();
        $result = "";
        foreach ($collection as $product) {
            $observer->updateUrlRewrite($product);
            $result .= $product->getId() . " ";
        }

        $this->getResponse()->setBody($result);
    }

}