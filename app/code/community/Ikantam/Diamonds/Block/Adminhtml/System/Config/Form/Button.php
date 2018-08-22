<?php

class Ikantam_Diamonds_Block_Adminhtml_System_Config_Form_Button extends Mage_Adminhtml_Block_System_Config_Form_Field {

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {
        $this->setElement($element);

        $html = $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setType('button')
                ->setClass('scalable')
                ->setLabel('Refresh')
                ->setOnClick("new Ajax.Request('" . Mage::getUrl("diamonds/ajax/refreshUrlRewrite") . "', {
                    method:     'get',
                    onSuccess: function(transport){
                        if (transport.responseText){
                            alert(transport.responseText)
                        }
                    }
                });
                ")
                ->_toHtml();

        return $html;
    }

}

?>
