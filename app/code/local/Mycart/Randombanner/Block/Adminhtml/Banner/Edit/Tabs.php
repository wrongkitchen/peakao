<?php

class Mycart_Randombanner_Block_Adminhtml_Banner_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('banner_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('randombanner')->__('Banner Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('randombanner')->__('Banner Information'),
          'title'     => Mage::helper('randombanner')->__('Banner Information'),
          'content'   => $this->getLayout()->createBlock('randombanner/adminhtml_banner_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}