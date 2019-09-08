<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouses extends CI_Controller
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
        $this->viewFolder = "warehouses_v";
        $this->pageTitle = "Anbarlar";
        $this->pageTitleExt = PageTitleExt;
        $this->load->model('warehouse_model');
        $this->load->model('branches_model');
        $this->load->model('departments_model');

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
        $viewData->pageTitle        = "Anbar Əlavə Et".$this->pageTitleExt;
        $viewData->header           = "Anbar Əlavə Et";
        $viewData->branches         = $this->branches_model->getAll();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function save(){

        $this->load->library('form_validation');


        $this->form_validation->set_rules("warehouse-name","Anbar adı","required|trim");
        $this->form_validation->set_rules("branch","Filial","required|trim");
        $this->form_validation->set_rules("department","Şöbə","required|trim");
        $this->form_validation->set_rules("personInCharge","Məsul şəxs","required|trim");
        $this->form_validation->set_rules("description","Haqqında","trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $save = $this->warehouse_model->add(array(
                "branchID"      => $this->input->post("branch"),
                "departmentID"  => $this->input->post("department"),
                "name"          => $this->input->post("warehouse-name"),
                "personInCharge"=> $this->input->post("personInCharge"),
                "description"   => $this->input->post("description"),
                "createdAt"     => date('Y-m-d H:i:s')
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
            redirect(base_url('warehouses/add-warehouse'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "add";
            $viewData->pageTitle        = "Anbar Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Anbar Əlavə Et";
            $viewData->branches         = $this->branches_model->getAll();
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function update_form($id){

        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "update";
        $viewData->pageTitle        = "Anbar Redaktə Et".$this->pageTitleExt;
        $viewData->header           = "Anbar Redaktə Et";
        $viewData->warehouse        = $this->warehouse_model->get(array(
            "ID"=>$id
        ));
        $viewData->branches         = $this->branches_model->getAll();
        $viewData->departments      = $this->departments_model->getAll(array(
           "branchID"   => $viewData->warehouse->branchID
        ));


        if(!$viewData->warehouse):
            $viewData->result     = false;
        else:
            $viewData->result     = true;
        endif;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function update($id){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("warehouse-name","Anbar adı","required|trim");
        $this->form_validation->set_rules("branch","Filial","required|trim");
        $this->form_validation->set_rules("department","Şöbə","required|trim");
        $this->form_validation->set_rules("personInCharge","Məsul şəxs","required|trim");
        $this->form_validation->set_rules("description","Haqqında","trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $update = $this->warehouse_model->update(
                array(
                  "ID" => $id
                ),
                array(
                    "branchID"      => $this->input->post("branch"),
                    "departmentID"  => $this->input->post("department"),
                    "name"          => $this->input->post("warehouse-name"),
                    "personInCharge"=> $this->input->post("personInCharge"),
                    "description"   => $this->input->post("description"),
                    "updatedAt"     => date('Y-m-d H:i:s')
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
            redirect(base_url('warehouses'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "update";
            $viewData->pageTitle        = "Anbar Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Anbar Əlavə Et";
            $viewData->warehouse       = $this->warehouse_model->get(array(
                "ID"=>$id
            ));
            $viewData->branches          = $this->branches_model->getAll();
            $viewData->departments      = $this->departments_model->getAll(array(
                "branchID"   => $viewData->warehouse->branchID
            ));
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function delete($id){

        $delete = $this->warehouse_model->delete(array(
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
        redirect(base_url('warehouses'));
    }

    public function isActiveSetter($id)
    {
        if ($id) {
            $isChecked = ($this->input->post("isChecked") === "true") ? 1 : 0;
            $isActive = $this->warehouse_model->update(
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
        echo $this->warehouse_model->getDataTable();
    }

}