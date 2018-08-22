<?php


$this->startSetup();
$cmsPagesData = array(
	array(
		'title' => 'Shapes tutorial',
		'root_template' => 'one_column',
		'meta_keywords' => 'meta,keywords',
		'meta_description' => 'meta description',
		'identifier' => 'shapes_tutorial',
		'content_heading' => 'content heading',
		'stores' => array(0),
		'content' => "Shapes tutorial"
	),
	array(
		'title' => 'Carat Weight tutorial',
		'root_template' => 'one_column',
		'meta_keywords' => 'meta,keywords',
		'meta_description' => 'meta description',
		'identifier' => 'carat_weight_tutorial',
		'content_heading' => 'content heading',
		'stores' => array(0),
		'content' => "Carat Weight tutorial"
	),
	array(
		'title' => 'Cut tutorial',
		'root_template' => 'one_column',
		'meta_keywords' => 'meta,keywords',
		'meta_description' => 'meta description',
		'identifier' => 'cut_tutorial',
		'content_heading' => 'content heading',
		'stores' => array(0),
		'content' => "Cut tutorial"
	),
	array(
		'title' => 'Color tutorial',
		'root_template' => 'one_column',
		'meta_keywords' => 'meta,keywords',
		'meta_description' => 'meta description',
		'identifier' => 'color_tutorial',
		'content_heading' => 'content heading',
		'stores' => array(0),
		'content' => "Color tutorial"
	),
	array(
		'title' => 'Clarity tutorial',
		'root_template' => 'one_column',
		'meta_keywords' => 'meta,keywords',
		'meta_description' => 'meta description',
		'identifier' => 'clarity_tutorial',
		'content_heading' => 'content heading',
		'stores' => array(0),
		'content' => "Clarity tutorial"
	),
	array(
		'title' => 'Certificates tutorial',
		'root_template' => 'one_column',
		'meta_keywords' => 'meta,keywords',
		'meta_description' => 'meta description',
		'identifier' => 'certificates_tutorial',
		'content_heading' => 'content heading',
		'stores' => array(0),
		'content' => "Certificates tutorial"
	)
);

foreach($cmsPagesData as $cmsPageData){
	Mage::getModel('cms/page')->setData($cmsPageData)->save();
}
$this->endSetup();
