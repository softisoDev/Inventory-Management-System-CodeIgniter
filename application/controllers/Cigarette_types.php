<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cigarette_types extends CI_Controller
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
        $this->viewFolder = "cigarette_types_v";
        $this->pageTitle = "Siqaret növülar";
        $this->pageTitleExt = PageTitleExt;
        $this->load->model('cigarette_types_model');
        $this->load->model('units_model');
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
        $viewData->pageTitle        = "Siqaret növü Əlavə Et".$this->pageTitleExt;
        $viewData->header           = "Siqaret növü Əlavə Et";
        $viewData->units            = $this->units_model->getAll();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function save(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("cigarette-name","Siqaret növü Adı","required|trim");
        $this->form_validation->set_rules("expTobac","Tütün miqdarı","required|trim|numeric");
        $this->form_validation->set_rules("unit-name","Ölçü vahidi","required|trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!",
            "numeric" => "{field} yalnız ədəd ola bilər!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $save = $this->cigarette_types_model->add(array(
                "name"          => $this->input->post("cigarette-name"),
                "expTobac"      => $this->input->post("expTobac"),
                "unitID"        => $this->input->post("unit-name")
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
            redirect(base_url('cigarette-types/add-type'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "add";
            $viewData->pageTitle        = "Siqaret növü Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Siqaret növü Əlavə Et";
            $viewData->units            = $this->units_model->getAll();
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function update_form($id){

        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "update";
        $viewData->pageTitle        = "Siqaret növü Redaktə Et".$this->pageTitleExt;
        $viewData->header           = "Siqaret növü Redaktə Et";
        $viewData->units            = $this->units_model->getAll();

        $viewData->items            = $this->cigarette_types_model->get(array(
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

        $this->form_validation->set_rules("cigarette-name","Siqaret növü Adı","required|trim");
        $this->form_validation->set_rules("expTobac","Tütün miqdarı","required|trim|numeric");
        $this->form_validation->set_rules("unit-name","Ölçü vahidi","required|trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!",
            "numeric" => "{field} yalnız ədəd ola bilər!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $update = $this->cigarette_types_model->update(
                array(
                  "ID" => $id
                ),
                array(
                    "name"          => $this->input->post("cigarette-name"),
                    "expTobac"      => $this->input->post("expTobac"),
                    "unitID"        => $this->input->post("unit-name")
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
            redirect(base_url('cigarette_types'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "update";
            $viewData->pageTitle        = "Siqaret növü Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Siqaret növü Əlavə Et";
            $viewData->cigaretteTypes   = $this->cigarette_types_model->getAll();
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function delete($id){

        $delete = $this->cigarette_types_model->delete(array(
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
        redirect(base_url('cigarette-types'));
    }

    public function getDataTable(){
        echo $this->cigarette_types_model->getDataTable();
    }

}