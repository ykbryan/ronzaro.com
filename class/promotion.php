<?php

class promotion{
	public $id, $code, $name, $description, $is_free_shirt, $is_used;
	
	function set_parameters($id, $code, $name, $description, $is_free_shirt){
		$this->id = $id;
		$this->code = $code;
		$this->name = $name;
		$this->description = $description;
		$this->is_free_shirt = $is_free_shirt;
	}
}

?>