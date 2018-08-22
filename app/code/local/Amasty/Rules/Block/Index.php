<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Rules
 */
class Amasty_Rules_Block_Index extends Mage_Core_Block_Template
{
    protected $_values = null;

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        if ($headBlock = $this->getLayout()->getBlock('head')) {
            $headBlock->setTitle($this->__('Loyalty Program'));
        }
    }

    protected function _getCurrentStore()
    {
        return Mage::app()->getStore()->getId();
    }

    protected function _getValues($key)
    {
        if (is_null($this->_values)) {
            $values = array();
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            $store = Mage::app()->getStore();
            $calc = Mage::getModel('amrules/calculator');
            // membership
            $values['membership_days'] = Mage::helper('amrules')->getMembership($customer->getCreatedAt());
            // all period
            $allPeriod = $calc->getAllPeriodTotal($customer->getId());
            $values['all_of_placed_orders']    = $allPeriod['of_placed_orders'];
            $values['all_total_orders_amount'] = $store->convertPrice($allPeriod['total_orders_amount'], true, false);
            $values['all_average_order_value'] = $store->convertPrice($allPeriod['average_order_value'], true, false);
            // this month
            $thisMonth = $calc->getThisMonthTotal($customer->getId());
            $values['this_of_placed_orders']    = $thisMonth['of_placed_orders'];
            $values['this_total_orders_amount'] = $store->convertPrice($thisMonth['total_orders_amount'], true, false);
            $values['this_average_order_value'] = $store->convertPrice($thisMonth['average_order_value'], true, false);
            // last month
            $lastMonth = $calc->getLastMonthTotal($customer->getId());
            $values['last_of_placed_orders']    = $lastMonth['of_placed_orders'];
            $values['last_total_orders_amount'] = $store->convertPrice($lastMonth['total_orders_amount'], true, false);
            $values['last_average_order_value'] = $store->convertPrice($lastMonth['average_order_value'], true, false);

            $this->_values = $values;
        }

        return isset($this->_values[$key]) ? $this->_values[$key] : 0;
    }

    public function getMembership()
    {
        return $this->_getValues('membership_days');
    }

    public function getOrdersCount()
    {
        return $this->_getValues('all_of_placed_orders');
    }

    public function getOrdersAve()
    {
        return $this->_getValues('all_average_order_value');
    }

    public function getOrdersAmount()
    {
        return $this->_getValues('all_total_orders_amount');
    }

    public function getThisMonthCount()
    {
        return $this->_getValues('this_of_placed_orders');
    }

    public function getThisMonthAve()
    {
        return $this->_getValues('this_average_order_value');
    }

    public function getThisMonthAmount()
    {
        return $this->_getValues('this_total_orders_amount');
    }

    public function getLastMonthCount()
    {
        return $this->_getValues('last_of_placed_orders');
    }

    public function getLastMonthAve()
    {
        return $this->_getValues('last_average_order_value');
    }

    public function getLastMonthAmount()
    {
        return $this->_getValues('last_total_orders_amount');
    }
}