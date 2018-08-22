<?php

class Ikantam_Diamonds_Model_Adminhtml_System_Config_Source_Attribute {

    protected $_options;

    public function toOptionArray() {
        if (!$this->_options) {
            $sets = new Mage_Eav_Model_Resource_Entity_Attribute_Set_Collection();
            $set = $sets->addFieldToFilter('attribute_set_name', 'Loose Diamonds')->getFirstItem();



            $attributesInfo = Mage::getResourceModel('eav/entity_attribute_collection');
            $attributesInfo->setAttributeSetFilter($set->getId())
                    ->setEntityTypeFilter('4')
                    ->addSetInfo();



            foreach ($attributesInfo as $attribute) {
                /* var_dump($attribute->getData()); */
                $attribute = Mage::getModel('eav/entity_attribute')->load($attribute['attribute_id']);
                if ($attribute->getData('frontend_label')!= null){
                    $this->_options[] = array(
                        'value' => $attribute->getData('attribute_code'),
                        'label' => $attribute->getData('frontend_label')
                    );
                }
            };
        }

        return $this->_options;
    }

}

?>
