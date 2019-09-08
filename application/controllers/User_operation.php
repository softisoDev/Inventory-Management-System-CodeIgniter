<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_operation extends CI_Controller
{

    public $viewFolder = "";
    public $pageTitle = "";
    public $pageTitleExt = "";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = "login_v";
        $this->pageTitle = "Login";
        $this->pageTitleExt = PageTitleExt;
        $this->load->model('users_model');
    }

    public function index(){
        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->pageTitle        = $this->pageTitle.$this->pageTitleExt;
        $viewData->header           = $this->pageTitle;

        $this->load->view("{$viewData->viewFolder}/index",$viewData);
    }

    public function login(){
        if(get_active_user()){
            redirect(base_url());
        }
        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->pageTitle        = $this->pageTitle.$this->pageTitleExt;
        $viewData->header           = $this->pageTitle;

        $this->load->view("{$viewData->viewFolder}/index",$viewData);
    }

    public function do_login(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("user-name","İstiadəçi adı","required|trim");
        $this->form_validation->set_rules("user-password","Parol","required|trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $user = $this->users_model->get(array(
               "uname"     => $this->input->post('user-name'),
               "password"  => sha1($this->input->post('user-password'))
            ));

            if(!empty($user) && $user){
                $this->session->set_userdata("user", $user);
                redirect(base_url());
            }
            else{
                $viewData = new stdClass();
                $viewData->viewFolder       = $this->viewFolder;
                $viewData->pageTitle        = $this->pageTitle.$this->pageTitleExt;
                $viewData->header           = $this->pageTitle;
                $viewData->wrongDetail      = true;

                $this->load->view("{$viewData->viewFolder}/index",$viewData);
            }
        }
        else{
            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->pageTitle        = $this->pageTitle.$this->pageTitleExt;
            $viewData->header           = $this->pageTitle;
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/index",$viewData);
        }
    }

    public function logout(){

        $this->session->unset_userdata("user");
        redirect(base_url("login"));
    }

    public function deneme(){
        echo sha1('yalcin789');
    }


}