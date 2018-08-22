<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Rules
 */


class Amasty_Rules_Model_Rule_Condition_Total_Status extends Mage_Rule_Model_Condition_Abstract {

    public function loadAttributeOptions() 
    {
        $statuses = Mage::getModel('sales/order_status')->getResourceCollection()->getData();
        $options = $this->getAttributeOptions();
        foreach ($statuses as $status) {
            $options[$status['status']] = $status['label'];
        }
        
        if (Mage::helper('core')->isModuleEnabled('Amasty_Orderstatus')) {
            $hideState = false;
            if (Mage::getStoreConfig('amorderstatus/general/hide_state')) {
                $hideState = true;
            }
            $statusesCollection = Mage::getModel('amorderstatus/status')->getCollection();
            if ($statusesCollection->getSize() > 0) {
                $config = Mage::getConfig();
                foreach ($config->getNode('global/sales/order/states')->children() as $state => $node) {
                    $label = Mage::helper('sales')->__(trim( (string) $node->label ) );
                    $states[$label] = $state;
                }
                foreach ($states as $stateLabel => $state) {
                    foreach ($statusesCollection as $status) {
                        if ($status->getData('is_active') && !$status->getData('is_system')) {
                            // checking if we should apply status to the current state
                            $parentStates = array();
                            if ($status->getParentState()) {
                                $parentStates = explode(',', $status->getParentState());
                            }
                            if (!$parentStates || in_array($state, $parentStates)) {
                                $elementName = $state . '_' . $status->getAlias();
                                $options[$elementName] = ( $hideState ? '' : $stateLabel . ': ' ) . Mage::helper('amorderstatus')->__($status->getStatus());
                            }
                        }
                    }
                }
            }
        }

        $this->setAttributeOption($options);
        return $this;
    }
    
    public function loadOperatorOptions() 
    {
        $this->setOperatorOption(array(
                '='  => Mage::helper('rule')->__('is'),
                '<>' => Mage::helper('rule')->__('is not'),
        ));
        
        return $this;
    }

    public function asHtml() 
    {
        $html = $this->getTypeElement()->getHtml() .
                Mage::helper('amrules')->__("Order Status %s %s", $this->getOperatorElement()->getHtml(), $this->getAttributeElement()->getHtml()
        );
        if ($this->getId() != '1') {
            $html .= $this->getRemoveLinkHtml();
        }
        return $html;
    }

    public function validate(Varien_Object $object) 
    {
        $result = array('status' => $this->getOperatorForValidate() . "'" . $this->getAttributeElement()->getValue() . "'");
        return $result;
    }

}

