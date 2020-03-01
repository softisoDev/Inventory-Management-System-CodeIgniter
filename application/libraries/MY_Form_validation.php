<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation{

    protected $ci;

    public function __construct(array $rules = array())
    {
        parent::__construct($rules);
        $this->ci =& get_instance();
    }
    /*** This function check given string contains only from alpha with spaces or not. (UTF-8) supported ***/
    public function only_alpha_ws($str){
        $check =  (bool) preg_match('/^[\p{L} ]+$/u', $str);
        /*$this->ci->form_validation->set_message('only_alpha_ws', '%s yalniz herflerden ibaret ola biler');*/
        if($check){
            return true;
        }
        else{
            return false;
        }
    }

	function add_to_error_array($field = '', $message = '')
	{
		if ( ! isset($this->_error_array[$field]))
		{
			$this->_error_array[$field] = $message;
		}

		return;
	}

	function error_array()
	{
		if (count($this->_error_array) === 0)
			return FALSE;
		else
			return $this->_error_array;
	}

}
