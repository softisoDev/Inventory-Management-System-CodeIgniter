<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Units extends CI_Controller{

    public $viewFolder   = "";
    public $pageTitle    = "";
    public $pageTitleExt = "";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder   = "units_v";
        $this->pageTitle    = "Ölçü Vahidləri";
        $this->pageTitleExt = PageTitleExt;

        $this->load->model('units_model');

    }

    public function index(){

        $viewData = new stdClass();
        $viewData->viewFolder    = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->pageTitle     = $this->pageTitle.$this->pageTitleExt;
        $viewData->items         = $this->units_model->getAll();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/list/index",$viewData);
    }

    public function new_form(){

        $viewData = new stdClass();
        $viewData->viewFolder    = $this->viewFolder;
        $viewData->subViewFolder = "teachers";
        $viewData->pageTitle     = "Müəllim Əlavə Et".$this->pageTitleExt;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/add/index",$viewData);

    }

    public function save(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("fullname","Müəllim Adı","required|trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){

            $save = $this->units_model->add(array(
                "fullName"   => $this->input->post('fullname'),
                "createdAt" => date("Y-m-d H:i:s"),
                "createdBy" => $this->session->userdata('admin-login')->ID
            ));

            if($save){
                $alert = array(
                    "title"    => "Əməliyyat uğurla yerinə yetirildi",
                    "text"     => "",
                    "type"     => "success",
                    "position" => "toast-top-center"
                );
                $this->session->set_flashdata("alert",$alert);
                redirect(base_url('teachers'));
            }
            else{

                $alert = array(
                    "title"    => "Üzr istəyirik!",
                    "text"     => "Bilinməyən xəta baş verdi. Zəhmət olmasa birazdan bir daha cəhd edin",
                    "type"     => "error",
                    "position" => "toast-top-center"
                );
                $this->session->set_flashdata("alert",$alert);
                redirect(base_url('teachers/add-teacher'));
            }


        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder    = $this->viewFolder;
            $viewData->subViewFolder = "teachers";
            $viewData->pageTitle     = "Müəllim Əlavə Et".$this->pageTitleExt;
            $viewData->form_error    = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/add/index",$viewData);
        }

    }

    public function update_form($id){

        $viewData = new stdClass();
        $viewData->viewFolder    = $this->viewFolder;
        $viewData->subViewFolder = "teachers";
        $viewData->pageTitle     = "Müəllim Redaktə Et".$this->pageTitleExt;

        $getData = $this->units_model->get(array(
            "ID" => $id
        ));

        if($getData){
            $viewData->item = $getData;
        }
        else{
            redirect(base_url('teachers'));
        }

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/update/index",$viewData);
    }

    public function update($id){
        $this->load->library('form_validation');

        $this->form_validation->set_rules("fullname","Müəllim Adı","required|trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){

            $save = $this->units_model->update(
                array(
                    "ID" => $id
                ),
                array(
                    "fullName"   => $this->input->post('fullname'),)
            );

            if($save){
                $alert = array(
                    "title"    => "Əməliyyat uğurla yerinə yetirildi",
                    "text"     => "",
                    "type"     => "success",
                    "position" => "toast-top-center"
                );
                $this->session->set_flashdata("alert",$alert);
                redirect(base_url('teachers'));
            }
            else{

                $alert = array(
                    "title"    => "Üzr istəyirik!",
                    "text"     => "Bilinməyən xəta baş verdi. Zəhmət olmasa birazdan bir daha cəhd edin",
                    "type"     => "error",
                    "position" => "toast-top-center"
                );
                $this->session->set_flashdata("alert",$alert);
                redirect(base_url('teachers'));
            }


        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder    = $this->viewFolder;
            $viewData->subViewFolder = "teachers";
            $viewData->pageTitle     = "Müəllim Redaktə Et".$this->pageTitleExt;
            $viewData->form_error    = true;
            $viewData->item          = $id;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/update/index",$viewData);
        }
    }

    public function delete($id){

        $delete = $this->units_model->delete(array(
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
        redirect(base_url('teachers'));
    }

    public function isActiveSetter($id)
    {
        if ($id) {
            $isChecked = ($this->input->post("isChecked") === "true") ? 1 : 0;
            $isActive = $this->units_model->update(
                array(
                    "ID" => $id
                ),
                array(
                    "isActive" => $isChecked
                )
            );
        }
    }

}