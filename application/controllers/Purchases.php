<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchases extends CI_Controller{

    public $viewFolder   = "";
    public $pageTitle    = "";
    public $pageTitleExt = "";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder   = "purchases_v";
        $this->pageTitle    = "Məhsullar";
        $this->pageTitleExt = PageTitleExt;
        $this->load->model('purchases_model');
        //$this->load->model('units_model');
        $this->load->model('warehouse_model');
        //$this->load->model('category_model');
    }

    public function index(){
        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "list";
        $viewData->pageTitle        = $this->pageTitle.$this->pageTitleExt;
        $viewData->header           = "Giriş Fakturaları";

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function new_form(){


        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "add";
        $viewData->pageTitle        = "Giriş Fakturası Yarat".$this->pageTitleExt;
        $viewData->header           = "Giriş Fakturası Yarat";
        $viewData->newCode          = $this->purchases_model->generate_autoCode();
        $viewData->warehouses       = $this->warehouse_model->getAll();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    

}