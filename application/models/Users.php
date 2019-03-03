<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller{


    public $viewFolder   = "";
    public $pageTitle    = "";
    public $pageTitleExt = "";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder   = "users_v";
        $this->pageTitle    = "Məhsullar";
        $this->pageTitleExt = PageTitleExt;
        $this->load->model('products_model');
        $this->load->model('units_model');
        $this->load->model('brands_model');
        $this->load->model('category_model');
    }


}