<?php
class  Mycart_Randombanner_Block_Adminhtml_Banner_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('bannerGrid');
      $this->setDefaultSort('name');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('randombanner/banner')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
	  
	  $this->addColumn('banner', array(
          'header'    => Mage::helper('randombanner')->__('Banner'),
          'align'     =>'left',
     
      ));

      $this->addColumn('name', array(
          'header'    => Mage::helper('randombanner')->__('Banner name'),
          'align'     =>'left',
          'index'     => 'name',
      ));
	  
      $this->addColumn('title', array(
          'header'    => Mage::helper('randombanner')->__('Banner title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

      $this->addColumn('link', array(
          'header'    => Mage::helper('randombanner')->__('Banner link'),
          'align'     =>'left',
          'index'     => 'link',
      ));

          $this->addColumn('size', array(
          'header'    => Mage::helper('randombanner')->__('Banner size'),
          'align'     =>'left',
          'index'     => 'size',
      ));

	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('randombanner')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('randombanner')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('banner_id');
        $this->getMassactionBlock()->setFormFieldName('banner');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('randombanner')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('randombanner')->__('Are you sure?')
        ));
		
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}