<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller
{

    public $viewFolder = "";
    public $pageTitle = "";
    public $pageTitleExt = "";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = "customers_v";
        $this->pageTitle = "Müştərilər/Carilər";
        $this->pageTitleExt = PageTitleExt;
        $this->load->model('customers_model');
    }

    public function index(){
        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "list";
        $viewData->pageTitle        = $this->pageTitle.$this->pageTitleExt;
        $viewData->header           = $this->pageTitle;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function new_form(){

        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "add";
        $viewData->pageTitle        = "Müştəri/Cari Əlavə Et".$this->pageTitleExt;
        $viewData->header           = "Müştəri/Cari Əlavə Et";
        $viewData->newCode          = $this->customers_model->generate_autoCode();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function save(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("auto-code","Avto Kod","required|trim");
        $this->form_validation->set_rules("code","Kod","required|trim");
        $this->form_validation->set_rules("customer-name","Müştəri/Cari Adı","required|trim");
        $this->form_validation->set_rules("email","Email","valid_email|trim");
        $this->form_validation->set_rules("company","Şirkət","trim");
        $this->form_validation->set_rules("address","Ünvan","trim");
        $this->form_validation->set_rules("telephone","Telefon","trim");
        $this->form_validation->set_rules("country","Ölkə","trim");
        $this->form_validation->set_rules("city","Şəhər","trim");
        $this->form_validation->set_rules("zipcode","Poçt Kodu","trim");
        $this->form_validation->set_rules("special1","Xüsusi Sahə 1","trim");
        $this->form_validation->set_rules("special2","Xüsusi Sahə 2","trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $save = $this->customers_model->add(array(
                "autoCode"          => $this->input->post("auto-code"),
                "code"              => $this->input->post("code"),
                "name"              => $this->input->post("customer-name"),
                "companyName"       => $this->input->post("company"),
                "address"           => $this->input->post("address"),
                "email"             => $this->input->post("email"),
                "telephone"         => $this->input->post("telephone"),
                "city"              => $this->input->post("city"),
                "country"           => $this->input->post("country"),
                "zipCode"           => $this->input->post("zipcode"),
                "special1"          => $this->input->post("special1"),
                "special2"          => $this->input->post("special2"),
                "createdAt"         => date('Y-m-d H:i:s')
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
            redirect(base_url('customers/add-customer'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "add";
            $viewData->pageTitle        = "Müştəri/Cari Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Müştəri/Cari Əlavə Et";
            $viewData->newCode          = $this->customers_model->generate_autoCode();
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function update_form($id){

        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "update";
        $viewData->pageTitle        = "Müştəri/Cari Redaktə Et".$this->pageTitleExt;
        $viewData->header           = "Müştəri/Cari Redaktə Et";
        $viewData->newCode          = $this->customers_model->generate_autoCode();
        $viewData->items            = $this->customers_model->get(array(
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
        $this->form_validation->set_rules("customer-name","Müştəri/Cari Adı","required|trim");
        $this->form_validation->set_rules("email","Email","valid_email|trim");
        $this->form_validation->set_rules("company","Şirkət","trim");
        $this->form_validation->set_rules("address","Ünvan","trim");
        $this->form_validation->set_rules("telephone","Telefon","trim");
        $this->form_validation->set_rules("country","Ölkə","trim");
        $this->form_validation->set_rules("city","Şəhər","trim");
        $this->form_validation->set_rules("zipcode","Poçt Kodu","trim");
        $this->form_validation->set_rules("special1","Xüsusi Sahə 1","trim");
        $this->form_validation->set_rules("special2","Xüsusi Sahə 2","trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $update = $this->customers_model->update(
                array(
                  "ID" => $id
                ),
                array(
                "code"              => $this->input->post("code"),
                "name"              => $this->input->post("customer-name"),
                "companyName"       => $this->input->post("company"),
                "address"           => $this->input->post("address"),
                "email"             => $this->input->post("email"),
                "telephone"         => $this->input->post("telephone"),
                "city"              => $this->input->post("city"),
                "country"           => $this->input->post("country"),
                "zipCode"           => $this->input->post("zipcode"),
                "special1"          => $this->input->post("special1"),
                "special2"          => $this->input->post("special2"),
                "updatedAt"         => date('Y-m-d H:i:s')
            ));

            if($update){
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
            redirect(base_url('customers'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "add";
            $viewData->pageTitle        = "Müştəri/Cari Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Müştəri/Cari Əlavə Et";
            $viewData->newCode          = $this->customers_model->generate_autoCode();
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function delete($id){

        $delete = $this->customers_model->delete(array(
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
        redirect(base_url('customers'));
    }


    public function isActiveSetter($id)
    {
        if ($id) {
            $isChecked = ($this->input->post("isChecked") === "true") ? 1 : 0;
            $isActive = $this->customers_model->update(
                array(
                    "ID" => $id
                ),
                array(
                    "isActive" => $isChecked
                )
            );
        }
    }

    public function getDataTable(){
        echo $this->customers_model->getDataTable();
    }

}