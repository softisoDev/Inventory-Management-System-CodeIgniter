<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public $viewFolder   = "";
    public $pageTitle    = "";
    public $pageTitleExt = "";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder   = "products_v";
        $this->pageTitle    = "Products";
        $this->pageTitleExt = PageTitleExt;

    }

    public function index(){
        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "list";
        $viewData->pageTitle        = $this->pageTitle.$this->pageTitleExt;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function getProductsTable(){
        $this->load->library('datatables');

        $this->datatables->select('code, changableCode, title, description, price, sellPrice');
        $this->datatables->from('products');
        /*$this->datatables->join('eventDescription', 'eventDescription.eventID=events.ID', 'left');
        $this->datatables->join('teachers', 'eventDescription.roomID=teachers.ID', 'left');
        $this->datatables->join('rooms', 'eventDescription.teacherID=rooms.ID', 'left');
        $this->datatables->add_column("edit","",'ID');*/
        echo $this->datatables->generate('json');
    }



}
