<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_handlings extends CI_Controller
{

    public $viewFolder = "";
    public $pageTitle = "";
    public $pageTitleExt = "";

    public function __construct()
    {
        parent::__construct();
        if(!get_active_user()){
            redirect(base_url("login"));
        }
        $this->viewFolder = "item_handlings_v";
        $this->pageTitle = "Malzeme hareketleri";
        $this->pageTitleExt = PageTitleExt;
        $this->load->model('item_handlings_model');
    }

    public function index(){
        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "list";
        $viewData->pageTitle        = $this->pageTitle.$this->pageTitleExt;
        $viewData->header           = $this->pageTitle;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function getDataTable(){

        if(!is_null($this->input->post("startDate")) && !is_null($this->input->post("endDate")) && !is_null($this->input->post("productCode"))){
            $where = array(
                "startDate" =>  $this->input->post("startDate"),
                "endDate" =>  $this->input->post("endDate"),
                "productCode" =>  $this->input->post("productCode")
            );
            echo $this->item_handlings_model->getDataTable($where);
        }
        else{
            $where = array(
                "startDate"   =>  "2019-07-24",
                "endDate"     =>  "2019-09-10",
                "productCode" =>  "XAM-TTN-009"
            );
             $this->item_handlings_model->getDataTable($where);
            print_r($this->db->last_query());
        }
    }

}