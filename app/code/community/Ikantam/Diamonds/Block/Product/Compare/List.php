<?php

class Ikantam_Diamonds_Block_Product_Compare_List extends Mage_Catalog_Block_Product_Compare_List {

    private $_comparableAttributes = array();
    
    /*
        'diamond_shape',
        'color_loose',
        'clarity',
        'cut',
        'length',
        'width',
        'estimated_retail_value',
        'treatment',
        'laboratory',
        'fluorescence',
        'culet',
        'girdle',
        'symmetry',
        'polish',
        'table2',
        'table',
        'depth2',
        'depth1',
        'cut',
        'carat',
        'clarity',
        'price_per_carat'
    );*/

    /* diamond_shape
      length
      width
      estimated_retail_value
      treatment
      laboratory
      fluorescence
      culet
      girdle
      symmetry
      polish
      table2
      table
      depth2
      depth1
      cut
      carat
      clarity
      price_per_carat */

    public function getAttributes() {
        /*if (is_null($this->_attributes)) {

             foreach ($this->_comparableAttributes as $attributeCode) {

              $attribute = Mage::getSingleton('eav/config')
              ->getAttribute(
              Ikantam_Diamonds_Model_Entity_Setup::ENTITY_TYPE_ID, $attributeCode
              );

              $this->_attributes[] = $attribute;
              }
              } */
            
            $this->_comparableAttributes = explode(',',Mage::helper('diamonds/config')->getCompareAttributes());
            if (is_null($this->_attributes)) {
                /*$groupsCollection = new Mage_Eav_Model_Resource_Entity_Attribute_Group_Collection();
                $groups = $groupsCollection->addFieldToFilter('attribute_group_name', array('in' => array('Special [Diamond]', 'Special [Loose Diamonds]')));

                $groupIds = array();
                foreach ($groups as $group) {
                    $groupIds[] = $group->getData('attribute_group_id');
                }



                $attributesCollection = Mage::getResourceModel('catalog/product_attribute_collection');
                // @var $attributesCollection Mage_Catalog_Model_Resource_Product_Attribute_Collection
                $attributesCollection->addFieldToFilter('is_comparable', 1);

                foreach ($groupIds as $id) {
                    $tmpAttributesCollection = $attributesCollection;
                    $tmpAttributesCollection->setAttributeGroupFilter($id);
                    foreach ($tmpAttributesCollection as $attribute) {
                        if (!in_array($attribute->getData('attribute_code'), explode(',',$this->_comparableAttributes))) {
                            $this->_comparableAttributes[] = $attribute->getData('attribute_code');
                            $this->_attributes[] = Mage::getSingleton('eav/config')
                                    ->getAttribute(Ikantam_Diamonds_Model_Entity_Setup::ENTITY_TYPE_ID, $attribute->getData('attribute_code'));
                        }
                    }
                }*/
                foreach ($this->_comparableAttributes as $attribute){
                    /*if (!in_array($attribute->getData('attribute_code'), $this->_comparableAttributes)) {*/
                                $this->_comparableAttributes[] = $attribute/*->getData('attribute_code')*/;

                                $this->_attributes[] = Mage::getSingleton('eav/config')
                                        ->getAttribute(Ikantam_Diamonds_Model_Entity_Setup::ENTITY_TYPE_ID, $attribute/*->getData('attribute_code')*/);
                    /*}*/
                }
            }
        
        return $this->_attributes;
    }

}

