<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branches extends CI_Controller
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
        $this->viewFolder = "branches_v";
        $this->pageTitle = "Filiallar";
        $this->pageTitleExt = PageTitleExt;
        $this->load->model('branches_model');
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
        $viewData->pageTitle        = "Filial Əlavə Et".$this->pageTitleExt;
        $viewData->header           = "Filial Əlavə Et";

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function save(){

        $this->load->library('form_validation');


        $this->form_validation->set_rules("branch-name","Filial adı","required|trim");
        $this->form_validation->set_rules("city","Şəhər","required|trim");
        $this->form_validation->set_rules("address","Ünvan","trim");
        $this->form_validation->set_rules("mail","Email","trim");
        $this->form_validation->set_rules("telephone","Telefon","trim");
        $this->form_validation->set_rules("description","Haqqında","trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $save = $this->branches_model->add(array(
                "name"          => $this->input->post("branch-name"),
                "description"   => $this->input->post("description"),
                "city"          => $this->input->post("city"),
                "address"       => $this->input->post("address"),
                "email"         => $this->input->post("mail"),
                "telephone"     => $this->input->post("telephone"),
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
            redirect(base_url('branches/add-branch'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "add";
            $viewData->pageTitle        = "Filial Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Filial Əlavə Et";
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function update_form($id){

        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "update";
        $viewData->pageTitle        = "Filial Redaktə Et".$this->pageTitleExt;
        $viewData->header           = "Filial Redaktə Et";
        $viewData->branch             = $this->branches_model->get(array(
            "ID"=>$id
        ));
        if(!$viewData->branch):
            $viewData->result     = false;
        else:
            $viewData->result     = true;
        endif;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function update($id){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("branch-name","Filial adı","required|trim");
        $this->form_validation->set_rules("city","Şəhər","required|trim");
        $this->form_validation->set_rules("address","Ünvan","trim");
        $this->form_validation->set_rules("mail","Email","trim");
        $this->form_validation->set_rules("telephone","Telefon","trim");
        $this->form_validation->set_rules("description","Haqqında","trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $update = $this->branches_model->update(
                array(
                  "ID" => $id
                ),
                array(
                    "name"          => $this->input->post("branch-name"),
                    "description"   => $this->input->post("description"),
                    "city"          => $this->input->post("city"),
                    "address"       => $this->input->post("address"),
                    "email"         => $this->input->post("mail"),
                    "telephone"     => $this->input->post("telephone"),
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
            redirect(base_url('branches'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "update";
            $viewData->pageTitle        = "Filial Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Filial Əlavə Et";
            $viewData->branch             = $this->branches_model->get(array(
                "ID"=>$id
            ));
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function delete($id){

        $delete = $this->branches_model->delete(array(
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
        redirect(base_url('branches'));
    }

    public function isActiveSetter($id)
    {
        if ($id) {
            $isChecked = ($this->input->post("isChecked") === "true") ? 1 : 0;
            $isActive = $this->branches_model->update(
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
        echo $this->branches_model->getDataTable();
    }

}