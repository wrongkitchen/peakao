<?php

class Ikantam_Diamonds_Model_Session {

    const DIAMOND = 'diamonds_selected_diamond';
    const RING = 'diamonds_selected_ring';
    const D_SETTINGS = 'diamonds_search_setting_diamond';
    const R_SETTINGS = 'diamonds_search_setting_ring';
    const SIZE = 'diamonds_selected_ring_size'; //22.08.2013

    private $_coreSession;

    public function __construct() {
        $this->_coreSession = Mage::getSingleton('core/session');
    }

    public function isDiamondSelected() {
        if (is_null($this->getSelectedDiamond())) {
            return false;
        }
        return true;
    }

    public function isRingSelected() {
        if (is_null($this->getSelectedRing())) {
            return false;
        }
        return true;
    }

    public function setSelectedDiamond($diamond) {
        $this->_coreSession->setData(self::DIAMOND, $diamond);
    }

    public function setSelectedRing($ring) {
        $this->_coreSession->setData(self::RING, $ring);
    }

    public function removeSelectedRing() {
        $this->_coreSession->setData(self::RING, null);
    }

    public function removeSelectedDiamond() {
        $this->_coreSession->setData(self::DIAMOND, null);
    }

    public function addDiamondSearchSettings($setting) {
        /*
          $oldSettings = $this->getDiamondSearchSettings();
          $resSettings = array_merge_recursive($oldSettings, $setting);
         */
        $this->_coreSession->setData(self::D_SETTINGS, $resSettings);
    }

    public function addRingSearchSettings($setting) {
        $this->_coreSession->setData(self::R_SETTINGS, $setting);
    }

    public function getSelectedDiamond() {
        return $this->_coreSession->getData(self::DIAMOND);
    }

    public function getSelectedRing() {
        return $this->_coreSession->getData(self::RING);
    }

    public function getDiamondSearchSettings() {
        return $this->_coreSession->getData(self::D_SETTINGS);
    }

    public function getRingSearchSettings() {
        return $this->_coreSession->getData(self::R_SETTINGS);
    }

    /* 22.08.2013 */

    public function setSelectedRingSize($ringSize) {
        $this->_coreSession->setData(self::SIZE, $ringSize);
    }

    public function removeSelectedRingSize() {
        $this->_coreSession->setData(self::SIZE, null);
    }

    public function getSelectedRingSize() {
        return $this->_coreSession->getData(self::SIZE);
    }

    /* End 22.08.2013 */
}