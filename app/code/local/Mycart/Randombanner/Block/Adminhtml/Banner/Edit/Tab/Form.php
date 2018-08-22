<?php

class Mycart_Randombanner_Block_Adminhtml_Banner_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('banner_form', array('legend'=>Mage::helper('randombanner')->__('Banner information')));
     
	  $fieldset->addField('image', 'image', array(
		'value' => '',
		'label' => 'Banner Image',
		'name'  => 'image',
        ));
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('randombanner')->__('Banner Name'),
          'required'  => true,
          'name'      => 'name',
      ));
          $fieldset->addField('link', 'text', array(
          'label'     => Mage::helper('randombanner')->__('Banner Links'),
          'required'  => true,
          'name'      => 'link',
      ));
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('randombanner')->__('Banner Title'),
          'required'  => false,
          'name'      => 'title',
      ));
     
      $fieldset->addField('size', 'text', array(
          'label'     => Mage::helper('randombanner')->__('Banner Size(w*h like 100*100)'),
          'required'  => false,
          'name'      => 'size',
      ));
      $fieldset->addField('type', 'text', array(
          'label'     => Mage::helper('randombanner')->__('Banner Type'),
          'required'  => false,
          'name'      => 'type',
      )); 


      if ( Mage::getSingleton('adminhtml/session')->getBannerData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getBannerData());
          Mage::getSingleton('adminhtml/session')->setBannerData(null);
      } elseif ( Mage::registry('banner_data') ) {
          $form->setValues(Mage::registry('banner_data')->getData());
      }
      return parent::_prepareForm();
  }
}