<?php
class Ikantam_Diamonds_Model_Adminhtml_System_Config_Source_Type {
    
    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label'=>Mage::helper('diamonds')->__('Checkboxes')),
            array('value' => 0, 'label'=>Mage::helper('diamonds')->__('Slider')),
        );
    }

    public function toArray()
    {
        return array(
            0 => Mage::helper('diamonds')->__('Slider'),
            1 => Mage::helper('diamonds')->__('Checkboxes'),
        );
    }
}
?>
