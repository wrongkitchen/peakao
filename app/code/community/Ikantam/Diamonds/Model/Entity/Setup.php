<?php

class Ikantam_Diamonds_Model_Entity_Setup extends Mage_Catalog_Model_Resource_Setup {

    const GROUP_NAME = 'Special';
    const ENTITY_TYPE_ID = 'catalog_product';

    private $_configModel;

    public function __construct($resourceName) {
        $this->_configModel = new Ikantam_Diamonds_Model_Config();
        parent::__construct($resourceName);
    }

    public function addAttributeSets() {
        $attrSets = $this->_configModel->getAttributeSets();

        foreach ($attrSets as $code => $attrSet) {
            $this->addAttributeSet(self::ENTITY_TYPE_ID, $attrSet['name']);
            $attrSetId = $this->getAttributeSetId(self::ENTITY_TYPE_ID, $attrSet['name']);


            if (isset($attrSet['skeleton'])) {
                $skeletonId = $this->getAttributeSetId(self::ENTITY_TYPE_ID, $attrSet['skeleton']);
            } else {
                //$skeletonId = null;
                $skeletonId = $this->getAttributeSetId(self::ENTITY_TYPE_ID, 'Default');
            }

            /* @var $attrSetModel Mage_Eav_Model_Entity_Attribute_Set */
            $attrSetModel = Mage::getModel('eav/entity_attribute_set')
                    ->load($attrSetId);

            $this->removeAttributeGroup(self::ENTITY_TYPE_ID, $attrSetModel->getId(), 'General');
            $attrSetModel->initFromSkeleton($skeletonId)->save();

            $attrGroupId = $this->_addSpecialGroupToSet($attrSet, $attrSetId);

            $this->_addAttributesToSpecialGroup($attrSet, $attrSetId, $attrGroupId);

            $attrSetModel->save();
        }
    }

    private function _addAttributesToSpecialGroup($attrSet, $attrSetId, $attrGroupId) {

        if (isset($attrSet['attributes'])) {

            foreach ($attrSet['attributes'] as $code => $attribute) {

                $this->addAttribute(self::ENTITY_TYPE_ID, $code, $this->_prepareDefaultValues($attribute));
                $this->addAttributeToGroup(self::ENTITY_TYPE_ID, $attrSetId, $attrGroupId, $code);

                if (isset($attribute['option'])) {
                    $attrId = $this->getAttributeId(self::ENTITY_TYPE_ID, $code);
                    $this->addAttributeOption($this->_optionsPrepare($attribute['option'], $attrId));
                }
            }
        }
    }

    private function _optionsPrepare($option, $attrId) {
        $optionsArr = explode(',', $option);
        $optionsPrepared = array();
        $optionsPrepared['attribute_id'] = $attrId;
        foreach ($optionsArr as $key => $value) {
            $value = trim($value);
            $optionsPrepared['value']['option' . $key][0] = $value;
        }

        return $optionsPrepared;
    }

    private function _addSpecialGroupToSet($attrSet, $setId) {
        $groupName = $this->_getSpecialGroupName($attrSet['name']);
        $this->addAttributeGroup(self::ENTITY_TYPE_ID, $setId, $groupName);
        return $this->getAttributeGroupId(self::ENTITY_TYPE_ID, $setId, $groupName);
    }

    private function _getSpecialGroupName($setName) {
        $specialGroupName = 'Special ' . '[' . $setName . ']';
        return $specialGroupName;
    }

    private function _prepareDefaultValues($attr) {
        $attr['is_configurable'] = 1;
        $attr['user_defined'] = 1;
        return $attr;
    }

    // Override magento class methods

    /**
     * Add attribute to an entity type
     *
     * @param string|integer $entityTypeId
     * @param string $code
     * @param array $attr
     * @return Mage_Eav_Model_Entity_Setup
     */
    public function addAttribute($entityTypeId, $code, array $attr) {
        $entityTypeId = $this->getEntityTypeId($entityTypeId);
        $data = array_merge(
                array(
            'entity_type_id' => $entityTypeId,
            'attribute_code' => $code
                ), $this->_prepareValues($attr)
        );

        $this->_validateAttributeData($data);

        $sortOrder = isset($attr['sort_order']) ? $attr['sort_order'] : null;
        $attributeId = $this->getAttribute($entityTypeId, $code, 'attribute_id');
        if ($attributeId) {
            $this->updateAttribute($entityTypeId, $attributeId, $data, null, $sortOrder);
        } else {
            $this->_insertAttribute($data);
        }

        if (isset($attr['option']) && is_array($attr['option'])) {
            $option = $attr['option'];
            $option['attribute_id'] = $this->getAttributeId($entityTypeId, $code);
            $this->addAttributeOption($option);
        }

        return $this;
    }

}