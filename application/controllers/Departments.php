<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departments extends CI_Controller
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
        $this->viewFolder = "departments_v";
        $this->pageTitle = "Şöbələr";
        $this->pageTitleExt = PageTitleExt;
        $this->load->model('departments_model');
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
        $viewData->pageTitle        = "Şöbə Əlavə Et".$this->pageTitleExt;
        $viewData->header           = "Şöbə Əlavə Et";
        $viewData->branches         = $this->branches_model->getAll();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function save(){

        $this->load->library('form_validation');


        $this->form_validation->set_rules("department-name","Şöbə adı","required|trim");
        $this->form_validation->set_rules("branch","Filial","required|trim");
        $this->form_validation->set_rules("mail","Email","trim");
        $this->form_validation->set_rules("telephone","Telefon","trim");
        $this->form_validation->set_rules("description","Haqqında","trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $save = $this->departments_model->add(array(
                "branchID"      => $this->input->post("branch"),
                "name"          => $this->input->post("department-name"),
                "description"   => $this->input->post("description"),
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
            redirect(base_url('departments/add-department'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "add";
            $viewData->pageTitle        = "Şöbə Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Şöbə Əlavə Et";
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function update_form($id){

        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "update";
        $viewData->pageTitle        = "Şöbə Redaktə Et".$this->pageTitleExt;
        $viewData->header           = "Şöbə Redaktə Et";
        $viewData->department       = $this->departments_model->get(array(
            "ID"=>$id
        ));
        $viewData->branches          = $this->branches_model->getAll();

        if(!$viewData->department):
            $viewData->result     = false;
        else:
            $viewData->result     = true;
        endif;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function update($id){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("department-name","Şöbə adı","required|trim");
        $this->form_validation->set_rules("branch","Filial","required|trim");
        $this->form_validation->set_rules("mail","Email","trim");
        $this->form_validation->set_rules("telephone","Telefon","trim");
        $this->form_validation->set_rules("description","Haqqında","trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $update = $this->departments_model->update(
                array(
                  "ID" => $id
                ),
                array(
                    "branchID"      => $this->input->post("branch"),
                    "name"          => $this->input->post("department-name"),
                    "description"   => $this->input->post("description"),
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
            redirect(base_url('departments'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "update";
            $viewData->pageTitle        = "Şöbə Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Şöbə Əlavə Et";
            $viewData->department       = $this->departments_model->get(array(
                "ID"=>$id
            ));
            $viewData->branches          = $this->branches_model->getAll();
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function delete($id){

        $delete = $this->departments_model->delete(array(
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
        redirect(base_url('departments'));
    }

    public function isActiveSetter($id)
    {
        if ($id) {
            $isChecked = ($this->input->post("isChecked") === "true") ? 1 : 0;
            $isActive = $this->departments_model->update(
                array(
                    "ID" => $id
                ),
                array(
                    "isActive" => $isChecked
                )
            );
        }
    }

    public function getSelectBox(){
        $result = '<option value="">Şöbə seç</option>';
        if(!is_null($this->input->post('branchID'))){
            $fetchData = $this->departments_model->getAll(array(
               "branchID"   => $this->input->post('branchID')
            ));
            foreach ($fetchData as $data){
                $result .= '<option value="'.$data->ID.'">'.$data->name.'</option>';
            }
        }
        else{
            $result = '<option value="">Məlumat tapılmadı</option>';
        }
        echo $result;
    }

    public function getDataTable(){
        echo $this->departments_model->getDataTable();
    }

}