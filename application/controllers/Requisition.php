<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Requisition extends CI_Controller{

    public $viewFolder   = "";
    public $pageTitle    = "";
    public $pageTitleExt = "";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder   = "requisition_v";
        $this->pageTitle    = "Məhsullar";
        $this->pageTitleExt = PageTitleExt;
        $this->load->model('requisitions_model');
        //$this->load->model('units_model');
        //$this->load->model('brands_model');
        //$this->load->model('category_model');
    }

    public function index(){
        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "list";
        $viewData->pageTitle        = $this->pageTitle.$this->pageTitleExt;
        $viewData->header           = "Tələbnamələr";

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function searchDataJSON(){
        $keyWord = $this->input->post("request");
        $like   = array(
            "code" => $keyWord
        );
        $datas   = $this->requisitions_model->getAll(array(),$like);
        $jsonData = array();
        foreach ($datas as $data){
            array_push($jsonData,array("id"=>$data->ID,"label"=>$data->code,"value"=>$data->code));
        }
        echo json_encode($jsonData);
    }






}