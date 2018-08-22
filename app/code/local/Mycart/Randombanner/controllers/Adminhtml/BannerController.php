<?php

class Mycart_Randombanner_Adminhtml_BannerController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		
		$this->loadLayout()
			->_setActiveMenu('randombanner/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Banners Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('randombanner/banner')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('banner_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('randombanner/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Banner Manager'), Mage::helper('adminhtml')->__('Item Manager'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('randombanner/adminhtml_banner_edit'))
				->_addLeft($this->getLayout()->createBlock('randombanner/adminhtml_banner_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('randombanner')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			$data ['name'] = trim(preg_replace('/[^\w\s-]/','',$data ['name']));
			$data ['title'] = trim($data ['title']);
			$data ['type'] = trim(preg_replace('/[^\w\s-]/','',$data ['type']));
			$data ['size'] = trim(preg_replace('/[^\w\s-]/','',$data ['size']));
		
           
			//$data ['image'] = trim(preg_replace('/[^\w\s-]/','',$data ['size']));			
        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != ''){
	    try {
			$_FILES['image']['name']= trim($_FILES['image']['name']);
               $uploader = new Varien_File_Uploader('image');
               $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
               $uploader->setAllowRenameFiles(false);
               $uploader->setFilesDispersion(false);
               $media_path = Mage::getBaseDir('media').'/randombanner/'.$data ['name'];
               $imgFilename = $media_path . '/'.$_FILES['image']['name'];
		    $imgsrc = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'randombanner/'.$data ['name'].'/'. $_FILES['image']['name'];			   

			  $uploader->save($media_path,$_FILES['image']['name']);
			   $data ['image']=$imgsrc;
            }
             catch (Exception $e) {
             Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            $this->_redirect('*/*/new', array('id' => $data['id']));
            return;
           }
        }

			$model = Mage::getModel('randombanner/banner');	
			
			$model->setname($data ['name'])->setlink($data ['link'])
			->settitle($data ['title'])->setsize($data ['size'])->settype($data ['type'])
				->setId($this->getRequest()->getParam('id'));
			if ($imgsrc) $model->setimage($imgsrc);
			try {
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('randombanner')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('randombanner')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('randombanner/banner');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $applicationIds = $this->getRequest()->getParam('banner');
        if(!is_array($applicationIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($applicationIds as $applicationId) {
                    $application = Mage::getModel('randombanner/banner')->load($applicationId);
                    $application->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($applicationIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	public function newAction() {
		$this->_forward('edit');
	}
	
}