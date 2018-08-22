<?php

    $installer = $this;
    $installer->startSetup();   
    $installer->run("
        DROP TABLE IF EXISTS `{$installer->getTable("mycart_payease/cards")}`;
        CREATE TABLE `{$installer->getTable("mycart_payease/cards")}`(
        `card_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Card Id',
        `customer_id` int(10) unsigned default NULL,
        `subscription_id` varchar(30) DEFAULT NULL COMMENT 'Customer Subscription Id',
        `firstname` varchar(150) DEFAULT NULL COMMENT 'Card Customer First Name',
        `lastname` varchar(150) DEFAULT NULL COMMENT 'Card Customer Last Name',
        `postcode` varchar(50) DEFAULT NULL COMMENT 'Card Customer First Name',
        `country_id` varchar(10) DEFAULT NULL COMMENT 'Card Customer Country',
        `region_id` varchar(150) DEFAULT NULL COMMENT 'Card Customer Region',
        `city` varchar(150) DEFAULT NULL COMMENT 'Card Customer City',
        `company` varchar(255) DEFAULT NULL COMMENT 'Card Customer Company',
        `street` varchar(255) NULL COMMENT 'Card Customer street',
        `telephone` varchar(50) NULL COMMENT 'Card Customer telephone',
        `cc_exp_month` varchar(255) DEFAULT NULL COMMENT 'Cc Exp Month',
        `cc_last4` varchar(255) DEFAULT NULL COMMENT 'Cc Last4',
        `cc_type` varchar(255) DEFAULT NULL COMMENT 'Cc Type',
        `cc_exp_year` varchar(255) DEFAULT NULL COMMENT 'Cc Exp Year',
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Created At',
        `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Updated At',
        PRIMARY KEY (`card_id`),
        KEY `FK_CUSTOMER_ID_PAYEASE` (`customer_id`),
        CONSTRAINT `FK_CUSTOMER_ID_PAYEASE` FOREIGN KEY (`customer_id`) REFERENCES `{$installer->getTable('customer_entity')}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE)ENGINE=InnoDB  DEFAULT CHARSET=utf8;        

        ALTER TABLE `{$installer->getTable('sales/quote_payment')}` ADD `mycart_payease_subscription_id` varchar(30) DEFAULT NULL COMMENT 'Payease customer payment subscription id';
        ALTER TABLE `{$installer->getTable('sales/quote_payment')}` ADD `mycart_payease_requestid` varchar(30) DEFAULT NULL COMMENT 'Payease Request ID';
        ALTER TABLE `{$installer->getTable('sales/order_payment')}` ADD `mycart_payease_subscription_id` varchar(30) DEFAULT NULL COMMENT 'Payease customer payment subscription id';               
        ALTER TABLE `{$installer->getTable('sales/order_payment')}` ADD `mycart_payease_requestid` varchar(30) DEFAULT NULL COMMENT 'Payease Request Id';        
        ");
    $quoteToken=$installer->getConnection()->tableColumnExists($installer->getTable('sales/quote_payment'),'PAYEASE_token','');
    if($quoteToken==false){
        $installer->run("   
            ALTER TABLE `{$installer->getTable('sales/quote_payment')}` ADD `PAYEASE_token` varchar(255) DEFAULT NULL COMMENT 'Payease Token';        
            ");
    }
    $orderToken=$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_payment'),'PAYEASE_token','');
    if($orderToken==false){
        $installer->run("   
            ALTER TABLE `{$installer->getTable('sales/order_payment')}` ADD `PAYEASE_token` varchar(255) DEFAULT NULL COMMENT 'Payease Token';        
            ");
    }
    $invoiceToken=$installer->getConnection()->tableColumnExists($installer->getTable('sales/invoice'),'PAYEASE_token','');
    if($invoiceToken==false){
        $installer->run("   
            ALTER TABLE `{$installer->getTable('sales/invoice')}` ADD `PAYEASE_token` varchar(255) DEFAULT NULL COMMENT 'Payease Token';        
            ");
    }
    $creditToken=$installer->getConnection()->tableColumnExists($installer->getTable('sales/creditmemo'),'PAYEASE_token','');
    if($creditToken==false){
        $installer->run("   
            ALTER TABLE `{$installer->getTable('sales/creditmemo')}` ADD `PAYEASE_token` varchar(255) DEFAULT NULL COMMENT 'Payease Token';        
            ");
    }
    $installer->endSetup();

