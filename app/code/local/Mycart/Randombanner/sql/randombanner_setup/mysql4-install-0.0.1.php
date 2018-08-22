<?php
//core_resource table
$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS `{$this->getTable('randombanner')}`;
CREATE TABLE `{$this->getTable('randombanner')}` (

`banner_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`image` VARCHAR( 100 ) NOT NULL ,
`name` VARCHAR( 64 ) NOT NULL ,
`title` VARCHAR( 100 ) NOT NULL ,
`link` VARCHAR( 100 ) NOT NULL ,
`size` VARCHAR( 32 ) NOT NULL ,
`type` VARCHAR( 32 ) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;"
);

$installer->endSetup(); 