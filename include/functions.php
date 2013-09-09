<?php
class functions{
	function __construct(){
	}

	function countDim($array)
	{
		if(is_array($array)){
			if (is_array(reset($array)))
				$return = $this->countdim(reset($array)) + 1;
			else
				$return = 1;

			return $return;
		} else return false;
	}
}