<?php

class Ikantam_Diamonds_Model_Config {
    /* @var $_config Mage_Core_Model_Config */

    private $_config;

    const CONFIG_PATH = 'default/ikantam_diamonds';
    const ATTRIBUTE_SETS = 'attribute_sets';
    //const DIAMONDS_ATTRIBUTE_SET = 14;
    //const RING_ATTRIBUTE_SET = 12;
    //const DEFAULT_SHAPE = "Round";
    const LOOSE_COLOR = 'color_loose';
    const FANCY_COLOR = 'color_fancy';

    public function __construct() {
        $config = Mage::getConfig();

        if ($config) {
            $this->_config = $config;
        } else {
            throw new Exception(Mage::helper('diamonds')->__('Config error'));
        }
    }

    public function getConfig() {
        return $this->_config;
    }

    public function getAttributeSets() {
        return $this->_getNode(self::ATTRIBUTE_SETS);
    }

    private function _getNode($path) {
        return $this->_config->getNode(self::CONFIG_PATH . '/' . $path)->asArray();
    }

    /* public function getSizeOptionData()
      {
      $sizes = array();
      for( $i = 3; $i <= 12; $i += 0.25 ){
      $sizes[] = $i;
      }

      $values = array();
      foreach($sizes as $key => $size){
      $values[] = array(
      'is_delete'     => 0,
      'title'         => strval($size),
      'price_type'    => '',
      'price'         => '',
      'sku'           => '',
      'option_type_id'=> -1,
      'sort_order'	=> $key
      );
      }


      $optionData = array(
      'is_delete'         => 0,
      'is_require'        => true,
      'previous_group'    => '',
      'title'             => 'Size',
      'type'              => 'drop_down',
      'price_type'        => '',
      'price'             => '',
      'sort_order'        => 0,
      'values'            => $values

      );

      return $optionData;
      } */
}

