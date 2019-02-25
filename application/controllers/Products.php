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
        $this->pageTitle    = "Məhsullar";
        $this->pageTitleExt = PageTitleExt;

    }

    public function index(){
        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "list";
        $viewData->pageTitle        = $this->pageTitle.$this->pageTitleExt;
        $viewData->header           = "Məhsullar";
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function new_form(){

    }

    public function getProductsTable(){
        $this->load->library('datatables');

        $this->datatables->select('products.ID, autoCode, code, title, brands.name AS brandName, categories.name AS categoryName, units.shortName, cost, price, price2,  VAT, barcode, barcode2, stockAmount, criticStockAmount, shelfNo, products.createdAt,  special1, special2, products.isActive AS productStatus, products.updatedAt, products.description, changableCode');
        $this->datatables->from('products');
        $this->datatables->join('categories', 'products.categoryID=categories.ID', 'left');
        $this->datatables->join('brands', 'products.brandID=brands.ID', 'left');
        $this->datatables->join('units', 'products.unitID=units.ID', 'left');
        /*$this->datatables->add_column("edit","
                            <button type='button' class='btn btn-icon btn-info btn-sm actions-buttons'>
                            <i class='la la-eye'></i>
                            </button>
                            <button type='button' class='btn btn-icon btn-success btn-sm actions-buttons'>
                            <i class='la la-pencil'></i>
                            </button>
                            <button type='button' class='btn btn-icon btn-danger btn-sm actions-buttons'>
                            <i class='la la-trash'></i>
                            </button>
                            
                            ",'ID');*/
        echo $this->datatables->generate('json');
    }



}
