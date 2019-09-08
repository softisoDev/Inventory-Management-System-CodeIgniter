<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public $viewFolder   = "";
    public $pageTitle    = "";
    public $pageTitleExt = "";

    public function __construct()
    {
        parent::__construct();
        if(!get_active_user()){
            redirect(base_url("login"));
        }
        $this->viewFolder   = "products_v";
        $this->pageTitle    = "Məhsullar";
        $this->pageTitleExt = PageTitleExt;
        $this->load->model('products_model');
        $this->load->model('units_model');
        $this->load->model('brands_model');
        $this->load->model('category_model');
        $this->load->model('warehouse_products_model');
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


        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "add";
        $viewData->pageTitle        = "Məhsul Yarat".$this->pageTitleExt;
        $viewData->header           = "Məhsul Yarat";
        $viewData->newCode          = $this->products_model->generate_autoCode();
        $viewData->units            = $this->units_model->getAll(array("isActive"=>1));
        $viewData->brands           = $this->brands_model->getAll(array("isActive"=>1));
        $viewData->categories       = $this->category_model->getAll(array("isActive"=>1));

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function save(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("auto-code","Avto Kod","required|trim");
        $this->form_validation->set_rules("code","Kod","required|trim");
        $this->form_validation->set_rules("product-name","Məhsul Adı","required|trim");
        $this->form_validation->set_rules("brand","Müəllim Adı","required|trim");
        $this->form_validation->set_rules("category","Kateqoriya","required|trim");
        $this->form_validation->set_rules("unit","Ölçü Vahidi","required|trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $save = $this->products_model->add(array(
                "autoCode"          => $this->input->post("auto-code"),
                "code"              => $this->input->post("code"),
                "changableCode"     => $this->input->post("changable-code"),
                "title"             => $this->input->post("product-name"),
                "description"       => $this->input->post("description"),
                "categoryID"        => $this->input->post("category"),
                "brandID"           => $this->input->post("brand"),
                "unitID"            => $this->input->post("unit"),
                "cost"              => $this->input->post("cost"),
                "price"             => $this->input->post("price-1"),
                "price2"            => $this->input->post("price-2"),
                "VAT"               => $this->input->post("vat"),
                "barcode"           => $this->input->post("barcode-1"),
                "barcode2"          => $this->input->post("barcode-2"),
                "criticStockAmount" => $this->input->post("critic-amount"),
                "shelfNo"           => $this->input->post("shelf-no"),
                "special1"          => $this->input->post("special-1"),
                "special2"          => $this->input->post("special-2"),
                "createdAt"         => date('Y-m-d H:i:s'),
                "createdBy"         => 1
            ));

            if($save){
                $alert = array(
                    "title"    => "Əməliyyat uğurla yerinə yetirildi",
                    "text"     => "",
                    "type"     => "success",
                    "position" => "toast-top-center"
                );
                $this->session->set_flashdata("alert",$alert);
            }
            else{

                $alert = array(
                    "title"    => "Üzr istəyirik!",
                    "text"     => "Bilinməyən xəta baş verdi. Zəhmət olmasa birazdan bir daha cəhd edin",
                    "type"     => "error",
                    "position" => "toast-top-center"
                );
                $this->session->set_flashdata("alert",$alert);
            }
            redirect(base_url('products/create-product'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "add";
            $viewData->pageTitle        = "Xəta!".$this->pageTitleExt;
            $viewData->header           = "Məhsul Yarat";
            $viewData->newCode          = $this->products_model->generate_autoCode();
            $viewData->units            = $this->units_model->getAll(array("isActive"=>1));
            $viewData->brands           = $this->brands_model->getAll(array("isActive"=>1));
            $viewData->categories       = $this->category_model->getAll(array("isActive"=>1));
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function update_form($id){

        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "update";
        $viewData->pageTitle        = "Məhsul Redaktə Et".$this->pageTitleExt;
        $viewData->header           = "Məhsul Redaktə Et";
        $viewData->newCode          = $this->products_model->generate_autoCode();
        $viewData->units            = $this->units_model->getAll(array("isActive"=>1));
        $viewData->brands           = $this->brands_model->getAll(array("isActive"=>1));
        $viewData->categories       = $this->category_model->getAll(array("isActive"=>1));
        $viewData->items            = $this->products_model->get(array(
           "ID"=>$id
        ));
        if(!$viewData->items):
              $viewData->result     = false;
        else: $viewData->result     = true;
        endif;
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function update($id){
        $this->load->library('form_validation');

        $this->form_validation->set_rules("auto-code","Avto Kod","required|trim");
        $this->form_validation->set_rules("code","Kod","required|trim");
        $this->form_validation->set_rules("product-name","Məhsul Adı","required|trim");
        $this->form_validation->set_rules("brand","Müəllim Adı","required|trim");
        $this->form_validation->set_rules("category","Kateqoriya","required|trim");
        $this->form_validation->set_rules("unit","Ölçü Vahidi","required|trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $update = $this->products_model->update(
                array(
                    "ID"            => $id
                ),
                array(
                "code"              => $this->input->post("code"),
                "changableCode"     => $this->input->post("changable-code"),
                "title"             => $this->input->post("product-name"),
                "description"       => $this->input->post("description"),
                "categoryID"        => $this->input->post("category"),
                "brandID"           => $this->input->post("brand"),
                "unitID"            => $this->input->post("unit"),
                "cost"              => $this->input->post("cost"),
                "price"             => $this->input->post("price-1"),
                "price2"            => $this->input->post("price-2"),
                "VAT"               => $this->input->post("vat"),
                "barcode"           => $this->input->post("barcode-1"),
                "barcode2"          => $this->input->post("barcode-2"),
                "criticStockAmount" => $this->input->post("critic-amount"),
                "shelfNo"           => $this->input->post("shelf-no"),
                "special1"          => $this->input->post("special-1"),
                "special2"          => $this->input->post("special-2"),
                "updatedAt"         => date('Y-m-d H:i:s')
            ));

            if($update){
                $alert = array(
                    "title"    => "Əməliyyat uğurla yerinə yetirildi",
                    "text"     => "Məhsul Uğurla Redaktə Olundu",
                    "type"     => "success",
                    "position" => "toast-top-full-width"
                );
                $this->session->set_flashdata("alert",$alert);
            }
            else{

                $alert = array(
                    "title"    => "Üzr istəyirik!",
                    "text"     => "Bilinməyən xəta baş verdi. Zəhmət olmasa birazdan bir daha cəhd edin",
                    "type"     => "error",
                    "position" => "toast-top-center"
                );
                $this->session->set_flashdata("alert",$alert);
            }
            redirect(base_url('products'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "update";
            $viewData->pageTitle        = "Məhsul Redaktə Et".$this->pageTitleExt;
            $viewData->header           = "Məhsul Redaktə Et";
            $viewData->newCode          = $this->products_model->generate_autoCode();
            $viewData->units            = $this->units_model->getAll(array("isActive"=>1));
            $viewData->brands           = $this->brands_model->getAll(array("isActive"=>1));
            $viewData->categories       = $this->category_model->getAll(array("isActive"=>1));
            $viewData->form_error       = true;
            $viewData->items            = $this->products_model->get(array(
                "ID"=>$id
            ));
            if(!$viewData->items):
                $viewData->result     = false;
            else: $viewData->result     = true;
            endif;
            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }

    }

    public function delete($id){

        $delete = $this->products_model->delete(array(
            "ID" => $id
        ));

        if($delete){
            $alert = array(
                "title"    => "Əməliyyat uğurla yerinə yetirildi",
                "text"     => "Məlumat silindi",
                "type"     => "success",
                "position" => "toast-top-center"
            );
        }
        else{
            $alert = array(
                "title"    => "Üzr istəyirik!",
                "text"     => "Bilinməyən xəta baş verdi. Zəhmət olmasa birazdan bir daha cəhd edin",
                "type"     => "error",
                "position" => "toast-top-center"
            );
        }

        $this->session->set_flashdata("alert",$alert);
        redirect(base_url('products'));
    }

    public function isActiveSetter($id)
    {
        if ($id) {
            $isChecked = ($this->input->post("isChecked") === "true") ? 1 : 0;
            $isActive = $this->products_model->update(
                array(
                    "ID" => $id
                ),
                array(
                    "isActive" => $isChecked
                )
            );
        }
    }

    public function checkProductCriticAmount(){
        $products = $this->warehouse_products_model->fetchCriticStockAmountProducts();
        print_r($products);
    }

    public function getDataTable(){
        $where = array();

        if(!is_null($this->input->post("productID"))){
            $where = array(
                "products.ID"    => $this->input->post("productID")
            );
        }
        if($this->uri->segment(3)){
            $where = array(
                "warehouseID"   => $this->uri->segment(3),
                "netQuantity >" => 0
            );
        }

        echo $this->products_model->getDataTable($where);
    }

    public function searchDataJSON(){
        $keyWord = $this->input->post("productCode");
        $like   = array(
            "code" => $keyWord
        );
        $datas   = $this->products_model->getAll(array(),$like);
        $jsonData = array();
        foreach ($datas as $data){
            array_push($jsonData,array("id"=>$data->code,"label"=>$data->code,"value"=>$data->code));
        }
        echo json_encode($jsonData);
    }


}

