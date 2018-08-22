<?php

class Ikantam_Diamonds_Block_Product_List_Toolbar_Pager extends Mage_Page_Block_Html_Pager
{
	
	public function getPreviousPage()
    {
        return $this->getCollection()->getCurPage(-1);
    }

    public function getNextPage()
    {
        return $this->getCollection()->getCurPage(+1);
    }
	
	
	
}