<?php

class address{
	public $id, $name, $address1, $address2, $city, $state, $zip, $country, $phone_number, $email;
	
	function set_parameters( $id, $name, $email, $address1, $address2, $city, $state, $zip, $country, $phone_number ){
		$this->id = $id;
		$this->name = $name;
		$this->email = $email;
		$this->address1 = $address1;
		$this->address2 = $address2;
		$this->city = $city;
		$this->state = $state;
		$this->zip = $zip;
		$this->country = $country;
		$this->phone_number = $phone_number;
	}	
	
}

?>