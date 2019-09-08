<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recipes extends CI_Controller
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
        $this->viewFolder = "recipes_v";
        $this->pageTitle = "Reçeteler";
        $this->pageTitleExt = PageTitleExt;
        $this->load->model('recipes_model');
        $this->load->model('recipes_items_model');
        $this->load->model('units_model');
        $this->load->model('warehouse_model');
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
        $viewData->pageTitle        = "Reçete Əlavə Et".$this->pageTitleExt;
        $viewData->header           = "Reçete Əlavə Et";
        $viewData->newCode          = $this->recipes_model->generate_autoCode();
        $viewData->units            = $this->units_model->getAll();
        $viewData->warehouses       = $this->warehouse_model->getAll();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function save(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("auto-code","Avto Kod","required|trim");
        $this->form_validation->set_rules("code","Kod","required|trim");
        $this->form_validation->set_rules("recipe-title","Reçete Adı","required|trim");
        $this->form_validation->set_rules("product-quantity[]","Məhsul Miqdarı","required|trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){

            $saveRecipe = $this->recipes_model->add(array(
                "autoCode"          => $this->input->post("auto-code"),
                "code"              => $this->input->post("code"),
                "title"             => $this->input->post("recipe-title")
            ));

            if($saveRecipe){
                $lastRecipeID = $this->db->insert_id();
                for($i=0;$i<count($this->input->post('productID[]'));$i++){

                    $saveRecipeItems = $this->recipes_items_model->add(array(
                        "recipeID"      => $lastRecipeID,
                        "productID"     => $this->input->post("productID[]")[$i],
                        "premixID"      => $this->input->post("premixID[]")[$i],
                        "warehouseID"   => $this->input->post("productWarehouse[]")[$i],
                        "amount"        => $this->input->post("product-quantity[]")[$i],
                        "unitID"        => $this->input->post("product-unit-db[]")[$i]
                    ));
                }

                if($saveRecipeItems){
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
            redirect(base_url('recipes/add-recipe'));

        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "add";
            $viewData->pageTitle        = "Reçete Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Reçete Əlavə Et";
            $viewData->newCode          = $this->recipes_model->generate_autoCode();
            $viewData->units            = $this->units_model->getAll();
            $viewData->warehouses       = $this->warehouse_model->getAll();
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function update_form($id){

        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "update";
        $viewData->pageTitle        = "Reçete Redaktə Et".$this->pageTitleExt;
        $viewData->header           = "Reçete Redaktə Et";
        $viewData->warehouses       = $this->warehouse_model->getAll();
        $viewData->units            = $this->units_model->getAll();
        $viewData->recipe           = $this->recipes_model->get(array(
            "ID"    => $id
        ));
        $viewData->recipeItems      = $this->recipes_items_model->getAll(
            array(
            "recipeID"  => $id
            ),
            true
        );
        if(!$viewData->recipe || !$viewData->recipeItems):
            $viewData->result     = false;
        else:
            $viewData->result     = true;
        endif;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function update($id){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("auto-code","Avto Kod","required|trim");
        $this->form_validation->set_rules("code","Kod","required|trim");
        $this->form_validation->set_rules("recipe-title","Reçete Adı","required|trim");
        $this->form_validation->set_rules("product-quantity[]","Məhsul Miqdarı","required|trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $updateRecipe = $this->recipes_model->update(
                array(
                  "ID" => $id
                ),
                array(
                    "code"              => $this->input->post("code"),
                    "title"             => $this->input->post("recipe-title")
                )
            );
            if($updateRecipe){
                $deleteOldData  = $this->recipes_items_model->delete(array(
                   "recipeID"   => $id
                ));

                if($deleteOldData){
                    for($i=0;$i<count($this->input->post('productID[]'));$i++){
                        $saveRecipeItems = $this->recipes_items_model->add(array(
                            "recipeID"      => $id,
                            "productID"     => $this->input->post("productID[]")[$i],
                            "premixID"      => $this->input->post("premixID[]")[$i],
                            "warehouseID"   => $this->input->post("productWarehouse[]")[$i],
                            "amount"        => $this->input->post("product-quantity[]")[$i],
                            "unitID"        => $this->input->post("product-unit-db[]")[$i]
                        ));
                    }
                }
                if($saveRecipeItems){
                    $alert = array(
                        "title"    => "Əməliyyat uğurla yerinə yetirildi",
                        "text"     => "",
                        "type"     => "success",
                        "position" => "toast-top-center"
                    );
                    $this->session->set_flashdata("alert",$alert);
                }
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
            redirect(base_url('recipes'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "add";
            $viewData->pageTitle        = "Reçete Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Reçete Əlavə Et";
            $viewData->newCode          = $this->recipes_model->generate_autoCode();
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function duplicate_new_form($id){

        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "duplicate";
        $viewData->pageTitle        = "Reçete Əlavə Et".$this->pageTitleExt;
        $viewData->header           = "Reçete Əlavə Et";
        $viewData->newCode          = $this->recipes_model->generate_autoCode();
        $viewData->units            = $this->units_model->getAll();
        $viewData->warehouses       = $this->warehouse_model->getAll();
        $viewData->recipeItems      = $this->recipes_items_model->getAll(
            array(
                "recipeID"  => $id
            ),
            true
        );

        if ($viewData->recipeItems):
            $viewData->result = true;
        else:
            $viewData->result = false;
        endif;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function delete($id){

        $deleteRecipeItems = $this->recipes_items_model->delete(array(
            "recipeID" => $id
        ));

        $deleteRecipe = $this->recipes_model->delete(array(
            "ID" => $id
        ));

        if($deleteRecipeItems && $deleteRecipe){
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
        redirect(base_url('recipes'));
    }

    public function isActiveSetter($id)
    {
        if ($id) {
            $isChecked = ($this->input->post("isChecked") === "true") ? 1 : 0;
            $isActive = $this->recipes_model->update(
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
        if($_POST):
            echo $this->recipes_model->getDataTable();
        endif;
    }

    public function add_table_row(){
        $rowID = $this->input->post('newRowID');
        $units    = $this->units_model->getAll();

        $rowHtml = "";
        $rowHtml .= '<tr id="items-table-row-'.$rowID.'">';
        $rowHtml .= '<td class="custom-product-td">';
        $rowHtml .= '<input type="text" required onfocus="addProduct(this)" name="product-code[]" class="form-control custom-product-input mySearch product-code">';
        $rowHtml .= '<input type="hidden" name="productID[]" class="productID">';
        $rowHtml .= '<input type="hidden" name="premixID[]" class="premixID">';
        $rowHtml .= '<input type="hidden" name="productWarehouse[]" class="productWarehouse">';
        $rowHtml .= '</td>';
        $rowHtml .= '<td class="custom-product-td">';
        $rowHtml .= '<input type="text" required name="product-name[]" readonly  class="form-control custom-product-input">';
        $rowHtml .= '</td>';
        $rowHtml .= '<td class="custom-product-td">';
        $rowHtml .= '<select name="product-unit[]" required class="form-control custom-product-select">';
        $rowHtml .= '<option value="">Ölçü Vahidi</option>';
        foreach ($units as $unit){
            $rowHtml .= '<option data-id="'.$unit->ID.'" value="'.$unit->name.'">'.$unit->name.'</option>';
        }
        $rowHtml .= '</select>';
        $rowHtml .= '<input type="hidden" class="product-unit-db" name="product-unit-db[]" required>';
        $rowHtml .= '</td>';
        $rowHtml .= '<td class="custom-product-td"><fieldset><div class="input-group">';
        $rowHtml .= '<input required type="text" name="product-quantity[]" type="text" class="form-control custom-product-input custom-touch-spin product-quantity sale-bill general-touchspin" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" onkeyup="checkMaxQuantity(this)" />';
        $rowHtml .= '<input class="max-quantity" id="max-quantity" name="max-quantity" type="hidden">';
        $rowHtml .= '</div></fieldset></td>';
        $rowHtml .= '<td class="custom-product-td product-operation-td"><i onclick="removeRow(this)" data-belong-row-id="'.$rowID.'" class="fa fa-trash red"></i></td>';
        $rowHtml .= '</tr>';

        echo $rowHtml;

    }

}