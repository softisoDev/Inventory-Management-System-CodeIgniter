<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Premixes extends CI_Controller
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
        $this->viewFolder = "premix_v";
        $this->pageTitle = "Premixes";
        $this->pageTitleExt = PageTitleExt;
        $this->load->model('premixes_model');
        $this->load->model('premixes_items_model');
        $this->load->model('units_model');
        $this->load->model('warehouse_model');
        $this->load->model('warehouse_products_model');
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
        $viewData->pageTitle        = "Premix Əlavə Et".$this->pageTitleExt;
        $viewData->header           = "Premix Əlavə Et";
        $viewData->newCode          = $this->premixes_model->generate_autoCode();
        $viewData->units            = $this->units_model->getAll();
        $viewData->warehouses       = $this->warehouse_model->getAll();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function save(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("auto-code","Avto Kod","required|trim");
        $this->form_validation->set_rules("code","Kod","required|trim");
        $this->form_validation->set_rules("premix-name","Premix Adı","required|trim");
        $this->form_validation->set_rules("productID[]","Məhsul ID","required|trim");
        $this->form_validation->set_rules("product-quantity[]","Məhsul Miqdarı","required|trim");
        $this->form_validation->set_rules("product-ratio[]","Nisbət","trim|required");
        $this->form_validation->set_rules("product-unit-db[]","Məhsulun ölçü vahidi","trim|required");


        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $savePremix = $this->premixes_model->add(array(
                "autoCode"          => $this->input->post("auto-code"),
                "code"              => $this->input->post("code"),
                "name"              => $this->input->post("premix-name"),
                "netAmount"         => $this->input->post("premix-total-amount"),
                "initialAmount"     => $this->input->post("premix-total-amount"),
                "unitID"            => 4
            ));

            if($savePremix){
                $lastPremixID = $this->db->insert_id();
                for($i=0;$i<count($this->input->post('productID[]'));$i++){
                    $amount = convertToKg($this->input->post("productID[]")[$i], $this->input->post("product-unit-db[]")[$i],$this->input->post("product-quantity[]")[$i]);
                    $savePremixItems = $this->premixes_items_model->add(array(
                        "premixID"      => $lastPremixID,
                        "productID"     => $this->input->post("productID[]")[$i],
                        "warehouseID"   => $this->input->post("productWarehouse[]")[$i],
                        "amount"        => $amount,
                        "ratio"         => $this->input->post("product-ratio[]")[$i],
                        "unitID"        => $this->input->post("product-unit-db[]")[$i]
                    ));

                    $this->warehouse_products_model->addOutAmount(
                        $this->input->post("productID[]")[$i],
                        $this->input->post("productWarehouse[]")[$i],
                        $this->input->post("product-quantity[]")[$i]
                    );
                    /* Check product for notification */
                    checkProductForNotification($this->input->post("productID[]")[$i], $this->input->post("productWarehouse[]")[$i]);
                }

                if($savePremixItems){
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
            redirect(base_url('premixes/add-premix'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "add";
            $viewData->pageTitle        = "Premix Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Premix Əlavə Et";
            $viewData->newCode          = $this->premixes_model->generate_autoCode();
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
        $viewData->pageTitle        = "Premix Redaktə Et".$this->pageTitleExt;
        $viewData->header           = "Premix Redaktə Et";
        $viewData->newCode          = $this->premixes_model->generate_autoCode();
        $viewData->warehouses       = $this->warehouse_model->getAll();
        $viewData->units            = $this->units_model->getAll();
        $viewData->premix           = $this->premixes_model->get(array(
            "ID"    => $id
        ));
        $viewData->premixItems      = $this->premixes_items_model->getAll(
            array(
            "premixID"  => $id
            ),
            true
        );
        if(!$viewData->premix || !$viewData->premixItems):
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
        $this->form_validation->set_rules("premix-name","Premix Adı","required|trim");
        $this->form_validation->set_rules("productID[]","Məhsul ID","required|trim");
        $this->form_validation->set_rules("product-quantity[]","Məhsul Miqdarı","required|trim");
        $this->form_validation->set_rules("product-ratio[]","Nisbət","trim|required");
        #$this->form_validation->set_rules("product-unit-db[]","Məhsulun ölçü vahidi","trim|required");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $updatePremix = $this->premixes_model->update(
                array(
                  "ID" => $id
                ),
                array(
                    "code"        => $this->input->post("code"),
                    "name"        => $this->input->post("premix-name"),
                    "netAmount"   => $this->input->post("premix-total-amount"),
                )
            );
            if($updatePremix){

                $oldItems = $this->premixes_items_model->getAll(
                    array(
                        "premixID" => $id
                    )
                );

                $decreaseAmountCheck = array();
                for ($i=0;$i<count($oldItems);$i++) {
                    if ($this->warehouse_products_model->decreaseOutAmount(
                        $oldItems[$i]->productID,
                        $oldItems[$i]->warehouseID,
                        $oldItems[$i]->amount
                    )){
                        $decreaseAmountCheck[] = true;
                    }
                    else{
                        $decreaseAmountCheck[] = false;
                    }
                }
                if(is_array($decreaseAmountCheck) && !in_array(false, $decreaseAmountCheck)){
                    $deleteOldData  = $this->premixes_items_model->delete(array(
                        "premixID"   => $id
                    ));

                    if($deleteOldData){
                        for($i=0;$i<count($this->input->post('productID[]'));$i++){
                            $savePremixItems = $this->premixes_items_model->add(array(
                                "premixID"      => $id,
                                "productID"     => $this->input->post("productID[]")[$i],
                                "warehouseID"   => $this->input->post("productWarehouse[]")[$i],
                                "amount"        => $this->input->post("product-quantity[]")[$i],
                                "ratio"         => $this->input->post("product-ratio[]")[$i],
                                "unitID"        => $this->input->post("product-unit-db[]")[$i]
                            ));
                            $this->warehouse_products_model->addOutAmount(
                                $this->input->post("productID[]")[$i],
                                $this->input->post("productWarehouse[]")[$i],
                                $this->input->post("product-quantity[]")[$i]
                            );
                            /* Check product for notification */
                            checkProductForNotification($this->input->post("productID[]")[$i], $this->input->post("productWarehouse[]")[$i]);
                        }

                        if($savePremixItems){
                            $alert = array(
                                "title"    => "Əməliyyat uğurla yerinə yetirildi",
                                "text"     => "",
                                "type"     => "success",
                                "position" => "toast-top-center"
                            );
                            $this->session->set_flashdata("alert",$alert);
                        }
                    }
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
            redirect(base_url('premixes'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "add";
            $viewData->pageTitle        = "Premix Əlavə Et".$this->pageTitleExt;
            $viewData->header           = "Premix Əlavə Et";
            $viewData->newCode          = $this->premixes_model->generate_autoCode();
            $viewData->units            = $this->units_model->getAll();
            $viewData->warehouses       = $this->warehouse_model->getAll();
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function duplicate_new_form($id){

        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "duplicate";
        $viewData->pageTitle        = "Premix Əlavə Et".$this->pageTitleExt;
        $viewData->header           = "Premix Əlavə Et";
        $viewData->newCode          = $this->premixes_model->generate_autoCode();
        $viewData->units            = $this->units_model->getAll();
        $viewData->warehouses       = $this->warehouse_model->getAll();
        $viewData->premixItems      = $this->premixes_items_model->getAll(
            array(
                "premixID"  => $id
            ),
            true
        );

        if ($viewData->premixItems):
            $viewData->result = true;
        else:
            $viewData->result = false;
        endif;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function delete($id){

        $oldItems = $this->premixes_items_model->getAll(
            array(
                "premixID" => $id
            )
        );

        $decreaseAmountCheck = array();
        for ($i=0;$i<count($oldItems);$i++) {
            if ($this->warehouse_products_model->decreaseOutAmount(
                $oldItems[$i]->productID,
                $oldItems[$i]->warehouseID,
                $oldItems[$i]->amount
            )){
                $decreaseAmountCheck[] = true;
            }
            else{
                $decreaseAmountCheck[] = false;
            }
        }
        if(is_array($decreaseAmountCheck) && !in_array(false, $decreaseAmountCheck)) {
            $deleteOldData = $this->premixes_items_model->delete(array(
                "premixID" => $id
            ));
            $deletePremix = $this->premixes_model->delete(array(
                "ID" => $id
            ));
            if($deleteOldData && $deletePremix){
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
                "text"     => "Bilinməyən xəta baş verdi. Zəhmət olmasa birazdan bir daha cəhd edin",
                "type"     => "error",
                "position" => "toast-top-center"
            );
        }

        $this->session->set_flashdata("alert",$alert);
        redirect(base_url('premixes'));
    }

    public function isActiveSetter($id)
    {
        if ($id) {
            $isChecked = ($this->input->post("isChecked") === "true") ? 1 : 0;
            $isActive = $this->premixes_model->update(
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
            echo $this->premixes_model->getDataTable();
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
        $rowHtml .= '<input type="hidden" name="productWarehouse[]" class="productWarehouse">';
        $rowHtml .= '</td>';
        $rowHtml .= '<td class="custom-product-td">';
        $rowHtml .= '<input type="text" required name="product-name[]" readonly  class="form-control custom-product-input">';
        $rowHtml .= '</td>';
        $rowHtml .= '<td class="custom-product-td">';
        $rowHtml .= '<select onchange="setUnitID2Input(this)" name="product-unit[]" required class="form-control custom-product-select product-unit" >';
        $rowHtml .= '<option value="">Ölçü Vahidi</option>';
        foreach ($units as $unit){
            $rowHtml .= '<option data-id="'.$unit->ID.'" value="'.$unit->name.'">'.$unit->name.'</option>';
        }
        $rowHtml .= '</select>';
        $rowHtml .= '<input type="hidden" class="product-unit-db" name="product-unit-db[]" required>';
        $rowHtml .= '</td>';
        $rowHtml .= '<td class="custom-product-td"><fieldset><div class="input-group">';
        $rowHtml .= '<input  onkeyup="calcRatio(this)" required type="text" name="product-quantity[]" type="text" class="form-control custom-product-input custom-touch-spin product-quantity sale-bill general-touchspin" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" />';
        $rowHtml .= '<input class="max-quantity" id="max-quantity" name="max-quantity" type="hidden">';
        $rowHtml .= '</div></fieldset></td>';
        $rowHtml .= '<td class="custom-product-td"><fieldset><div class="input-group">';
        $rowHtml .= '<input type="number" step="1" readonly  name="product-ratio[]" class="form-control custom-product-input product-ratio"/>';
        $rowHtml .= '</div></fieldset></td>';
        $rowHtml .= '<td class="custom-product-td product-operation-td"><i onclick="removeRow(this)" data-belong-row-id="'.$rowID.'" class="fa fa-trash red"></i></td>';
        $rowHtml .= '</tr>';

        echo $rowHtml;

    }

}