<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class machines extends CI_Controller
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
        $this->viewFolder = "machines_v";
        $this->pageTitle = "Makinalar";
        $this->pageTitleExt = PageTitleExt;
        $this->load->model('machines_model');
        $this->load->model('cigarette_types_model');
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
        $viewData->pageTitle        = "Makina Əlavə Et".$this->pageTitleExt;
        $viewData->header           = "Makina Əlavə Et";
        $viewData->cigaretteTypes   = $this->cigarette_types_model->getAll();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function save(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("machine-name","Makina Adı","required|trim");
        $this->form_validation->set_rules("avg-mc","Ortalama MC","required|trim|numeric");
        $this->form_validation->set_rules("cigarette-type","Siqaret Tipi","required|trim|numeric");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!",
            "numeric" => "{field} yalnız ədəd ola bilər!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $save = $this->machines_model->add(array(
                "name"          => $this->input->post("machine-name"),
                "avgMC"         => $this->input->post("avg-mc"),
                "cigTypeID"     => $this->input->post("cigarette-type")
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
            redirect(base_url('machines/add-machine'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "add";
            $viewData->pageTitle        = "Makina Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Makina Əlavə Et";
            $viewData->cigaretteTypes   = $this->cigarette_types_model->getAll();
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function update_form($id){

        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "update";
        $viewData->pageTitle        = "Makina Redaktə Et".$this->pageTitleExt;
        $viewData->header           = "Makina Redaktə Et";
        $viewData->cigaretteTypes   = $this->cigarette_types_model->getAll();

        $viewData->items            = $this->machines_model->get(array(
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

        $this->form_validation->set_rules("machine-name","Makina Adı","required|trim");
        $this->form_validation->set_rules("avg-mc","Ortalama MC","required|trim|numeric");
        $this->form_validation->set_rules("cigarette-type","Siqaret Tipi","required|trim|numeric");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!",
            "numeric" => "{field} yalnız ədəd ola bilər!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $update = $this->machines_model->update(
                array(
                  "ID" => $id
                ),
                array(
                    "name"          => $this->input->post("machine-name"),
                    "avgMC"         => $this->input->post("avg-mc"),
                    "cigTypeID"     => $this->input->post("cigarette-type")
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
            redirect(base_url('machines'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "add";
            $viewData->pageTitle        = "Makina Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Makina Əlavə Et";
            $viewData->newCode          = $this->machines_model->generate_autoCode();
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function delete($id){

        $delete = $this->machines_model->delete(array(
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
        redirect(base_url('machines'));
    }

    public function getMachine(){
        $result = array();
        if(!is_null($this->input->post('machine'))){
            $machine = $this->input->post('machine');
            $machine = (int) $machine;
            if($machine != "default" && is_int($machine)){
                $fetchData = $this->machines_model->get(array("ID"=>$machine));
                if($fetchData):
                    $result['error'] = 0;
                    $result['data'] = $fetchData;
                else:
                    $result['error'] = 1;
                endif;
            }
            else{
                $result['error'] = 1;
            }
        }
        else{
            $result['error'] = 1;
        }
        echo json_encode($result);
    }

    public function getDataTable(){
        echo $this->machines_model->getDataTable();
    }

}