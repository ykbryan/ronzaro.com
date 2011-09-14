<?php

class shirt{
	public $collection_shirt_id, $collar_id, $cuff_id, $pocket_id, $back_id, $bottom_id, $fit_id, $monogram_color, $monogram_placement, $monogram_text;
	public $name, $neck, $shoulder, $bicep, $armlength, $chest, $waist, $wrist, $hips, $shirtlength;
	public $quantity;
	public $is_standard = "N";
	public $size_id, $size_name;
	public $unit = "inches";
	
	function set_parameters( $collection_shirt_id, $collar_id, $cuff_id, $pocket_id, $back_id, $bottom_id, $fit_id, $monogram_color, $monogram_placement, $monogram_text ){
		$this->collection_shirt_id = $collection_shirt_id;
		$this->collar_id = $collar_id;
		$this->cuff_id = $cuff_id;
		$this->pocket_id = $pocket_id;
		$this->back_id = $back_id;
		$this->bottom_id = $bottom_id;
		$this->fit_id = $fit_id;
		$this->monogram_color = $monogram_color;
		$this->monogram_placement = $monogram_placement;
		$this->monogram_text = $monogram_text;
		$this->quantity = 1;
		
	}
	
	function set_measurement( $name, $neck, $shoulder, $bicep, $armlength, $chest, $waist, $wrist, $hips, $shirtlength ){
		$this->name = $name;
		$this->neck = $neck;
		$this->shoulder = $shoulder;
		$this->bicep = $bicep;
		$this->armlength = $armlength;
		$this->chest = $chest;
		$this->waist = $waist;
		$this->wrist = $wrist;
		$this->hips = $hips;
		$this->shirtlength = $shirtlength;
		
	}
	
	function set_standard( $neck, $armlength, $wrist, $chest, $size_id, $size_name ){
		$this->neck = $neck;
		$this->armlength = $armlength;
		$this->wrist = $wrist;
		$this->chest = $chest;
		$this->size_id = $size_id;
		$this->size_name = $size_name;
		$this->is_standard = "Y";
		
	}
	
	
}

?>