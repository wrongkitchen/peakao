<?php

class Mycart_Payease_Block_Redirect extends Mage_Core_Block_Abstract
{
    protected function _toHtml()
    {
        $standard = Mage::getModel('mycart_payease/payment');

        $form = new Varien_Data_Form();
        $form->setAction(Mage::getStoreConfig('payment/mycart_payease/soap_gateway_url'))
            ->setId('payease_checkout')
            ->setName('payease_checkout')
            ->setMethod('POST')
            ->setUseContainer(true);
		
        foreach ($standard->getCheckoutFormFields() as $field=>$value) {
            $form->addField($field, 'hidden', array('name'=>$field, 'value'=>$value));
        }
        $idSuffix = Mage::helper('core')->uniqHash();
        $submitButton = new Varien_Data_Form_Element_Submit(array(
            'value'    => $this->__('Click here if you are not redirected within 10 seconds...'),
        ));
        $id = "submit_to_paypal_button_{$idSuffix}";
        $submitButton->setId($id);
        $form->addElement($submitButton);
        $html = '<html><body>';
        $html.= $this->__('You will be redirected to the Payease website in a few seconds.');
        $html.= $form->toHtml();
       $html.= '<script type="text/javascript">document.getElementById("payease_checkout").submit();</script>';
        $html.= '</body></html>';

        return $html;
    }
}
