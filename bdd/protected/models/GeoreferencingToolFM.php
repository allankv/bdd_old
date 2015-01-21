<?php


class GeoreferencingToolFM extends CFormModel
{
	public $latitude;
	public $longitude;
	public $altitude;
        public $country;
        public $state;
        public $municipality;
        public $locality;

      
	public function rules()
	{
		return array(
			// username and password are required
			//array('locality, password', 'required'),
			// password needs to be authenticated
			//array('password', 'authenticate'),
		);
	}

}
