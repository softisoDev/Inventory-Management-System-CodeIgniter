<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Units extends CI_Controller
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
        $this->viewFolder = "units_v";
        $this->pageTitle = "Ölçü Vahidləri";
        $this->pageTitleExt = PageTitleExt;
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
        $viewData->pageTitle        = "Ölçü vahidi Əlavə Et".$this->pageTitleExt;
        $viewData->header           = "Ölçü vahidi Əlavə Et";

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function save(){

        $this->load->library('form_validation');


        $this->form_validation->set_rules("unit-name","Ölçü vahidi adı","required|trim");
        $this->form_validation->set_rules("unit-short-name","Qısa adı","required|trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $save = $this->units_model->add(array(
                "name"          => $this->input->post("unit-name"),
                "shortName"     => $this->input->post("unit-short-name")
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
            redirect(base_url('units/add-unit'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "add";
            $viewData->pageTitle        = "Ölçü vahidi Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Ölçü vahidi Əlavə Et";
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function update_form($id){

        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "update";
        $viewData->pageTitle        = "Ölçü vahidi Redaktə Et".$this->pageTitleExt;
        $viewData->header           = "Ölçü vahidi Redaktə Et";
        $viewData->unit             = $this->units_model->get(array(
            "ID"=>$id
        ));
        if(!$viewData->unit):
            $viewData->result     = false;
        else:
            $viewData->result     = true;
        endif;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function update($id){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("unit-name","Ölçü vahidi adı","required|trim");
        $this->form_validation->set_rules("unit-short-name","Qısa adı","required|trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $update = $this->units_model->update(
                array(
                  "ID" => $id
                ),
                array(
                    "name"          => $this->input->post("unit-name"),
                    "shortName"     => $this->input->post("unit-short-name")
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
            redirect(base_url('units'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "update";
            $viewData->pageTitle        = "Ölçü vahidi Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Ölçü vahidi Əlavə Et";
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function delete($id){

        $deletable = $this->units_model->getAll(array(
           "isDeletable" => 1
        ));
        $deletableUnits = array();
        foreach ($deletable as $del){
            array_push($deletableUnits, $del->ID);
        }

        if(in_array($id, $deletableUnits)){
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
        }
        else{
            $alert = array(
                "title"    => "Üzr istəyirik!",
                "text"     => "Bu əməliyyat sistem tərəfindən qadağan edilib",
                "type"     => "error",
                "position" => "toast-top-center"
            );
        }

        $this->session->set_flashdata("alert",$alert);
        redirect(base_url('units'));
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

    public function getDataTable(){
        echo $this->units_model->getDataTable();
    }

}