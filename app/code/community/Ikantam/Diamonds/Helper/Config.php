<?php

class Ikantam_Diamonds_Helper_Config extends Mage_Core_Helper_Abstract {

    /*Options*/
    const XML_PATH_BUNDLE_NAME                  = 'ikantam_diamonds/options/bundle_name';
    const XML_PATH_SHOW_SHAPE_NAME              = 'ikantam_diamonds/options/show_shape_name';
    const XML_PATH_ALLOW_ADD_RING_TO_CART       = 'ikantam_diamonds/options/allow_add_ring_to_cart';
    const XML_PATH_ENABLE_SEO_LINK              = 'ikantam_diamonds/options/enable_seo_link';
    const XML_PATH_SHOW_SIZE_RING_PAGE          = 'ikantam_diamonds/options/show_size_ring_page';
    
    
    /*Sliders*/
    const XML_PATH_WIDTH_SLIDER                 = 'ikantam_diamonds/sliders/width_slider';
	const XML_PATH_WIDTH_SLIDER_WITH_FIELDS     = 'ikantam_diamonds/sliders/width_slider_with_fields';
    const XML_PATH_MIN_CARAT_SLIDER             = 'ikantam_diamonds/sliders/min_carat_slider';
    const XML_PATH_MAX_CARAT_SLIDER             = 'ikantam_diamonds/sliders/max_carat_slider';
    const XML_PATH_STEP_CARAT_SLIDER            = 'ikantam_diamonds/sliders/step_carat_slider';
    const XML_PATH_MIN_PRICE_SLIDER             = 'ikantam_diamonds/sliders/min_price_slider';
    const XML_PATH_MAX_PRICE_SLIDER             = 'ikantam_diamonds/sliders/max_price_slider';
    const XML_PATH_STEP_PRICE_SLIDER            = 'ikantam_diamonds/sliders/step_price_slider';
    
    const XML_PATH_COLOR_SLIDER_TYPE            = 'ikantam_diamonds/sliders/color_slider_type';
    const XML_PATH_CLARITY_SLIDER_TYPE          = 'ikantam_diamonds/sliders/clarity_slider_type';
    const XML_PATH_CUT_SLIDER_TYPE              = 'ikantam_diamonds/sliders/cut_slider_type';
	
	const XML_PATH_FLUORESCENCE_SLIDER_TYPE     = 'ikantam_diamonds/sliders/fluorescence_slider_type';
	const XML_PATH_POLISH_SLIDER_TYPE           = 'ikantam_diamonds/sliders/polish_slider_type';
	const XML_PATH_SYMMETRY_SLIDER_TYPE         = 'ikantam_diamonds/sliders/symmetry_slider_type';
	
	const XML_PATH_MIN_TABLE_SLIDER             = 'ikantam_diamonds/sliders/min_table_slider';
    const XML_PATH_MAX_TABLE_SLIDER             = 'ikantam_diamonds/sliders/max_table_slider';
    const XML_PATH_STEP_TABLE_SLIDER            = 'ikantam_diamonds/sliders/step_table_slider';
	const XML_PATH_MIN_DEPTH_SLIDER             = 'ikantam_diamonds/sliders/min_depth_slider';
    const XML_PATH_MAX_DEPTH_SLIDER             = 'ikantam_diamonds/sliders/max_depth_slider';
    const XML_PATH_STEP_DEPTH_SLIDER            = 'ikantam_diamonds/sliders/step_depth_slider';
	
	const XML_PATH_CERTIFICATE_SLIDER_TYPE      = 'ikantam_diamonds/sliders/certificate_slider_type';
	
	
	const XML_PATH_METAL_SLIDER_TYPE            = 'ikantam_diamonds/sliders/metal_slider_type';
	/*const XML_PATH_CUT_SLIDER_TYPE = 'ikantam_diamonds/sliders/cut_slider_type';
	const XML_PATH_CUT_SLIDER_TYPE = 'ikantam_diamonds/sliders/cut_slider_type';
	const XML_PATH_CUT_SLIDER_TYPE = 'ikantam_diamonds/sliders/cut_slider_type';
	const XML_PATH_CUT_SLIDER_TYPE = 'ikantam_diamonds/sliders/cut_slider_type';*/
    
    /*Diamond List*/
    const XML_PATH_COMPARE_ATTRIBUTES           = 'ikantam_diamonds/diamond_list/compare_attributes';
    const XML_PATH_MODE_COMPARE_LIMIT           = 'ikantam_diamonds/diamond_list/mode_compare_limit';
    const XML_PATH_MODE_LIST_LIMIT              = 'ikantam_diamonds/diamond_list/mode_list_limit';
    const XML_PATH_MODE_GRID_LIMIT              = 'ikantam_diamonds/diamond_list/mode_grid_limit';

    const XML_PATH_DIAMOND_DISPLAY_INFO         = 'ikantam_diamonds/diamond_view/display_info';
    const XML_PATH_DIAMOND_DISPLAY_TUTORIAL     = 'ikantam_diamonds/diamond_view/display_tutorial';
    

    public function getBundleName() 			{ return Mage::getStoreConfig(self::XML_PATH_BUNDLE_NAME); }
    public function isShowShapeName() 			{ return Mage::getStoreConfig(self::XML_PATH_SHOW_SHAPE_NAME); }
    public function isAllowAddRingToCart() 		{ return Mage::getStoreConfig(self::XML_PATH_ALLOW_ADD_RING_TO_CART); }
    public function isEnableSeoLink() 			{ return Mage::getStoreConfig(self::XML_PATH_ENABLE_SEO_LINK); }
    public function isShowSizeRingPage() 		{ return Mage::getStoreConfig(self::XML_PATH_SHOW_SIZE_RING_PAGE); }

    
    public function getWidthSlider() 			{ return Mage::getStoreConfig(self::XML_PATH_WIDTH_SLIDER); }
	public function getWidthSliderWithFields() 			{ return Mage::getStoreConfig(self::XML_PATH_WIDTH_SLIDER_WITH_FIELDS); }
	
    public function getMinCaratSlider() 		{ return Mage::getStoreConfig(self::XML_PATH_MIN_CARAT_SLIDER); }
    public function getMaxCaratSlider() 		{ return Mage::getStoreConfig(self::XML_PATH_MAX_CARAT_SLIDER); }
    public function getStepCaratSlider() 		{ return Mage::getStoreConfig(self::XML_PATH_STEP_CARAT_SLIDER); }
    public function getMinPriceSlider() 		{ return Mage::getStoreConfig(self::XML_PATH_MIN_PRICE_SLIDER); }
    public function getMaxPriceSlider() 		{ return Mage::getStoreConfig(self::XML_PATH_MAX_PRICE_SLIDER); }
    public function getStepPriceSlider() 		{ return Mage::getStoreConfig(self::XML_PATH_STEP_PRICE_SLIDER); }
    
    
    public function getColorSliderType() 		{ return Mage::getStoreConfig(self::XML_PATH_COLOR_SLIDER_TYPE); }
    public function getClaritySliderType() 		{ return Mage::getStoreConfig(self::XML_PATH_CLARITY_SLIDER_TYPE); }
    public function getCutSliderType() 			{ return Mage::getStoreConfig(self::XML_PATH_CUT_SLIDER_TYPE); }
    
	
	public function getFluorescenceSliderType() { return Mage::getStoreConfig(self::XML_PATH_FLUORESCENCE_SLIDER_TYPE); }
    public function getPolishSliderType() 		{ return Mage::getStoreConfig(self::XML_PATH_POLISH_SLIDER_TYPE); }
    public function getSymmetrySliderType() 	{ return Mage::getStoreConfig(self::XML_PATH_SYMMETRY_SLIDER_TYPE); }
	public function getMinTableSlider() 		{ return Mage::getStoreConfig(self::XML_PATH_MIN_TABLE_SLIDER); }
    public function getMaxTableSlider() 		{ return Mage::getStoreConfig(self::XML_PATH_MAX_TABLE_SLIDER); }
    public function getStepTableSlider() 		{ return Mage::getStoreConfig(self::XML_PATH_STEP_TABLE_SLIDER); }
	public function getMinDepthSlider() 		{ return Mage::getStoreConfig(self::XML_PATH_MIN_DEPTH_SLIDER); }
    public function getMaxDepthSlider() 		{ return Mage::getStoreConfig(self::XML_PATH_MAX_DEPTH_SLIDER); }
    public function getStepDepthSlider() 		{ return Mage::getStoreConfig(self::XML_PATH_STEP_DEPTH_SLIDER); }	
	
    
	public function getCertificateSliderType() { return Mage::getStoreConfig(self::XML_PATH_CERTIFICATE_SLIDER_TYPE); }
	
	public function getRingMetalSliderType() 	{ return Mage::getStoreConfig(self::XML_PATH_METAL_SLIDER_TYPE); }
	
    public function getCompareAttributes() 		{ return Mage::getStoreConfig(self::XML_PATH_COMPARE_ATTRIBUTES); }
    public function getModeCompareLimit() 		{ return Mage::getStoreConfig(self::XML_PATH_MODE_COMPARE_LIMIT); }
    public function getModeGridLimit() 			{ return Mage::getStoreConfig(self::XML_PATH_MODE_GRID_LIMIT); }
    public function getModeListLimit() 			{ return Mage::getStoreConfig(self::XML_PATH_MODE_LIST_LIMIT); }
	
}
?>
