<?php

class Mycart_Ringadvisor_Block_Recommend extends Mage_Core_Block_Template
{
    public function __construct()
    {
		parent::__construct();
    }

    public function cartesian()
	{
			$data = func_get_args();
			$cnt = count($data);
			$result = array();
			foreach($data[0] as $item) {
			$result[] = array($item);
			}
			for($i = 1; $i < $cnt; $i++) {
			$result = $this->combineArray($result,$data[$i]);
			}
			return $result;
		}
		protected function combineArray($arr1,$arr2) {
			$result = array();
			foreach ($arr1 as $item1) {
			foreach ($arr2 as $item2) {
			$temp = $item1;
			$temp[] = $item2;
			$result[] = $temp;
			}
			}
			return $result;
			}
}
