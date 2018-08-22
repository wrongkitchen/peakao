<?php
class Ikantam_Diamonds_DebugController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {	
        
        var_dump(explode(',',Mage::helper('diamonds/config')->getCompareAttributes()));
                die();
        $sets = new Mage_Eav_Model_Resource_Entity_Attribute_Set_Collection();
        $set = $sets->addFieldToFilter('attribute_set_name', 'Loose Diamonds')->getFirstItem();



        $attributesInfo = Mage::getResourceModel('eav/entity_attribute_collection');
        $attributesInfo->setAttributeSetFilter($set->getId())
            ->setEntityTypeFilter('4');;
        
        /*Mage::getResourceModel('eav/entity_attribute_collection');*/
            /*->setEntityTypeFilter('4');  //4 = product entities*/
            /*->addFieldToFilter('attribute_set_id', $set->getId())*/
            /*->addSetInfo()*/
            /*->getData();*/



        foreach ($attributesInfo as $attribute) {
            /*var_dump($attribute->getData());*/
            $attribute = Mage::getModel('eav/entity_attribute')->load($attribute['attribute_id']);
            $this->_options[] = array(
                'value' => $attribute->getData('attribute_code'),
                'label' => $attribute->getData('frontend_label')
            );

        };
        var_dump($this->_options);
        die();
        
        
        
        
        $sets = new Mage_Eav_Model_Resource_Entity_Attribute_Set_Collection();
        $set = $sets->addFieldToFilter('attribute_set_name','Loose Diamonds')->getFirstItem();
        
        /*$sets->addFieldToFilter('')*/
    $groupsCollection = new Mage_Eav_Model_Resource_Entity_Attribute_Group_Collection();
    $groupsCollection->addFieldToFilter('attribute_set_id',$set->getAttributeSetId());
    
            $groups = $groupsCollection;
    /*->addFieldToFilter('attribute_group_name', array('in' => array('Special [Diamond]', 'Special [Loose Diamonds]')));*/

            $groupIds = array();
            foreach ($groups as $group) {
                $groupIds[] = $group->getData('attribute_group_id');
                /*var_dump($group->getData());*/
            }
/*die();*/

            $attributesCollection = Mage::getResourceModel('catalog/product_attribute_collection');
            // @var $attributesCollection Mage_Catalog_Model_Resource_Product_Attribute_Collection

            $this->_options = array();
            /*foreach ($groupIds as $id) {
               $tmpAttributesCollection = $attributesCollection;
              */ 
                /*$tmpAttributesCollection->setAttributeGroupFilter($id);*/
               /*$tmpAttributesCollection->addFieldToFilter('attribute_group_id',$id);*/
                /*echo $id;
                foreach ($tmpAttributesCollection as $attribute) {
                    
                       var_dump($attribute->getData('attribute_code'));
                }
            }*/
            
            
            die();
		$this->_redirect('diamonds/');
		return;
		
    }
    
    public function rcntlclearAction()
    {
    	$recentlyModel = Mage::getModel('diamonds/recently');
    	echo "count before " . count($recentlyModel->getDiamondsCollection());
    	$recentlyModel->clearDiamonds();
    	echo " count after" . count($recentlyModel->getDiamondsCollection());
    }
    
    public function addcompareAction()
    {
    	$id = $this->getRequest()->getParam('id');
    	$product= Mage::getModel('catalog/product')->load($id);
    	Mage::getSingleton('catalog/product_compare_list')->addProduct($product);
    	
    }
    
    public function upgradeAction()
    {
    	if(!$this->getRequest()->getParam('ok')) return;
    	
    	
    	$attrCodes = array(
    		'ring_sidestone_shape',
    		'ring_sidestone_clarity',
    		'ring_sidestone_color'	,
    		'ring_sidestone_cut',
    		'culet',
    		'girdle',
    		'treatment',
    		'laboratory',
    		'polish',
    		'symmetry',
    		'fluorescence'			
    	);
    	
    	
    	foreach ($attrCodes as $code){
    		$this->_addNAtoAttr($code);
    	}
    	
    	
    	
    }
    
    
    private function _addNAtoAttr($attrCode)
    {
    	
    	$arg_value = 'N/A';
    	$attr_model = Mage::getModel('catalog/resource_eav_attribute');
    	$attr = $attr_model->loadByCode('catalog_product', $attrCode);
    	$attr_id = $attr->getAttributeId();
    	 
    	$option['attribute_id'] = $attr_id;
    	$option['value']['option_n_a'][0] = $arg_value;
    	 
    	$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
    	$setup->addAttributeOption($option);  	
    	
    	
    }
    
    
    public function addselectionAction()
    {
    	$collectionBundle = Mage::getResourceModel('catalog/product_collection')
    		->addAttributeToFilter('type_id', array('eq' => 'bundle'));
    	$product = $collectionBundle->getFirstItem();
    	
    	
    	$options = $product->getTypeInstance(true)->getOptions($product);
    	$optionId = 1;
    	foreach($options as $option){
    			
    		if($option->getDefaultTitle() === 'Ring'){
    			$optionId = $option->getId();
    		}
    	}
    	
    	$collection = Mage::getModel('catalog/product')->getCollection()
    			->addAttributeToFilter(
    					'attribute_set_id',
    					Ikantam_Diamonds_Model_Config::RING_ATTRIBUTE_SET
    	);
    	
    	$selectionRawData = array();
    	$selectionRawData[0] = array();
    	$i = 0;
    	
    	$sql = "";
    	foreach($collection as $ring){
    		
    		$sql .= "(NULL, '15', '20', '" . $ring->getId() . "', '0', '0', '0', '1.0000', '', '1'),";
    		
    		
    		
    	}
    	
    	echo $sql;
    	
    	
    	
    	return null;
    	
    	
    	
    	
    	
    	
    	
    }
    
    
}