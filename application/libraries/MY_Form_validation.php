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

    /***  This Function check given data is double/float or not ***/
    public function only_float($num){

    }

}