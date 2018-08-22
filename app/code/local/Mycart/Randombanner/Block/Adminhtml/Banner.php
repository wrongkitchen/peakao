<?php
class Mycart_Randombanner_Block_Adminhtml_Banner extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_banner';
    $this->_blockGroup = 'randombanner';
    $this->_headerText = Mage::helper('core')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('core')->__('Add Item');
    parent::__construct();
  }
}