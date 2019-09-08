<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller
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
        $this->viewFolder = "categories_v";
        $this->pageTitle = "Kateqoriyalar";
        $this->pageTitleExt = PageTitleExt;
        $this->load->model('category_model');
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
        $viewData->pageTitle        = "Kateqoriya Əlavə Et".$this->pageTitleExt;
        $viewData->header           = "Kateqoriya Əlavə Et";
        $viewData->categories       = $this->category_model->getAll();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function save(){

        $this->load->library('form_validation');


        $this->form_validation->set_rules("category-name","Kateqoriya adı","required|trim");
        $this->form_validation->set_rules("parentCategory","Ana kateqoriya","required|trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $save = $this->category_model->add(array(
                "name"          => $this->input->post("category-name"),
                "parentID"      => $this->input->post("parentCategory")
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
            redirect(base_url('categories/add-category'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "add";
            $viewData->pageTitle        = "Kateqoriya Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Kateqoriya Əlavə Et";
            $viewData->categories       = $this->category_model->getAll();
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function update_form($id){

        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "update";
        $viewData->pageTitle        = "Kateqoriya Redaktə Et".$this->pageTitleExt;
        $viewData->header           = "Kateqoriya Redaktə Et";
        $viewData->categories       = $this->category_model->getAll();
        $viewData->category         = $this->category_model->get(array(
            "ID"=>$id
        ));
        if(!$viewData->category):
            $viewData->result     = false;
        else:
            $viewData->result     = true;
        endif;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function update($id){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("category-name","Kateqoriya adı","required|trim");
        $this->form_validation->set_rules("parentCategory","Ana kateqoriya","trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $update = $this->category_model->update(
                array(
                  "ID" => $id
                ),
                array(
                    "name"          => $this->input->post("category-name"),
                    "parentID"      => $this->input->post("parentCategory"),
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
            redirect(base_url('categories'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "update";
            $viewData->pageTitle        = "Kateqoriya Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Kateqoriya Əlavə Et";
            $viewData->categories       = $this->category_model->getAll();
            $viewData->category         = $this->category_model->get(array(
                "ID"=>$id
            ));
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function delete($id){

        $delete = $this->category_model->delete(array(
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
        redirect(base_url('categories'));
    }

    public function isActiveSetter($id)
    {
        if ($id) {
            $isChecked = ($this->input->post("isChecked") === "true") ? 1 : 0;
            $isActive = $this->category_model->update(
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
        echo $this->category_model->getDataTable();
    }

}