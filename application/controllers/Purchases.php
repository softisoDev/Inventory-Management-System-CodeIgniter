<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class Purchases extends CI_Controller{

    public $viewFolder   = "";
    public $pageTitle    = "";
    public $pageTitleExt = "";

    public function __construct()
    {
        parent::__construct();
        if(!get_active_user()){
            redirect(base_url("login"));
        }
        $this->viewFolder   = "purchases_v";
        $this->pageTitle    = "Məhsullar";
        $this->pageTitleExt = PageTitleExt;
        $this->load->model('item_slips_model');
        $this->load->model('item_handlings_model');
        $this->load->model('warehouse_products_model');
        $this->load->model('bill_Types_model');
        $this->load->model('warehouse_model');
        $this->load->model('persons_model');
        $this->load->model('requisitions_model');
        $this->load->model('currency_model');
        $this->load->model('units_model');
    }

    public function index(){
        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "list";
        $viewData->pageTitle        = $this->pageTitle.$this->pageTitleExt;
        $viewData->header           = "Giriş Fakturaları";

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function new_form(){

        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "add";
        $viewData->pageTitle        = "Giriş Fakturası Yarat".$this->pageTitleExt;
        $viewData->header           = "Giriş Fakturası Yarat";
        $viewData->newCode          = $this->item_slips_model->generate_autoCode('IPS');
        $viewData->warehouses       = $this->warehouse_model->getAll();
        $viewData->suppliers        = $this->persons_model->getAll(array("personType"=>"supplier"));
        $viewData->requisitions     = $this->requisitions_model->getAll();
        $viewData->currency         = $this->currency_model->getAll();
        $viewData->billTypes        = $this->bill_Types_model->getAll(array("type"=>"purchase"));
        $viewData->units            = $this->units_model->getAll();
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function save(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("auto-code","Avto Kod","required|trim");
        $this->form_validation->set_rules("code","Kod","required|trim");
        $this->form_validation->set_rules("warehouse","Anbar","required|trim");
        $this->form_validation->set_rules("supplier","Tədarükçü","required|trim");
        $this->form_validation->set_rules("billType","Əməliyyat Tipi","required|trim");
        $this->form_validation->set_rules("currency","Məzənnə","required|trim");
        $this->form_validation->set_rules("date","Tarix","required|trim");
        $this->form_validation->set_rules("requisition","Tələbnamə &#8470","trim");
        $this->form_validation->set_rules("productID[]","Məhsul ID","required|trim");
        $this->form_validation->set_rules("product-code[]","Məhsul Kodu","required|trim");
        $this->form_validation->set_rules("product-name[]","Məhsul Adı","required|trim");
        $this->form_validation->set_rules("product-unit[]","Ölçü Vahidi","required|trim");
        $this->form_validation->set_rules("product-quantity[]","Məhsul Miqdarı","required|trim");
        $this->form_validation->set_rules("product-price[]","Məhsul Qiyməti","required|trim");
        $this->form_validation->set_rules("product-discount[]","Məhsul Endirimi","trim");
        $this->form_validation->set_rules("product-grassTotal[]","Yekun Qiymət","required|trim");
        $this->form_validation->set_rules("totalProductDiscount","Cəm Məhsul Endirimi","required|trim");
        $this->form_validation->set_rules("totalDiscount","Cəm Endirim","required|trim");
        $this->form_validation->set_rules("grandTotal","Yekun Qiymət","required|trim");
        $this->form_validation->set_rules("generalDiscountValue","Ümumi Endirim","trim");
        $this->form_validation->set_rules("special-1","Xüsusi Sahə-1","trim");
        $this->form_validation->set_rules("special-2","Xüsusi Sahə-2","trim");
        $this->form_validation->set_rules("note","Qeyd","trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){

            $savePurchase = $this->item_slips_model->add(array(
                "autoCode"          => $this->input->post("auto-code"),
                "code"              => $this->input->post("code"),
                "personID"          => $this->input->post("supplier"),
                "warehouseTo"       => $this->input->post("warehouse"),
                "slipType"          => 'purchase',
                "billType "         => $this->input->post("billType"),
                "generalDiscountValue" => $this->input->post("generalDiscountValue"),
                "generalDiscount"   => $this->input->post("generalDiscountValue"),
                "totalProductDiscount" => $this->input->post("totalProductDiscount"),
                "TotalDiscount"     => $this->input->post("totalDiscount"),
                "grandTotal"        => $this->input->post("grandTotal"),
                "total"             => $this->input->post("grandTotal"),
                "currency"          => $this->input->post("currency"),
                "requisitionID"     => $this->input->post("requisition"),
                "date"              => $this->input->post("date")." ".date('H:i:s'),
                "note"              => $this->input->post("note"),
                "special1"          => $this->input->post("special-1"),
                "special2"          => $this->input->post("special-2"),
                "icon"              => 'fa fa-plus',
                "userID"            => 1
            ));

            if($savePurchase){
                $lastInsertId = $this->db->insert_id();
                $savePurchaseProducts = false;

                for($i=0;$i<count($this->input->post('productID[]'));$i++){
                    $savePurchaseProducts = $this->item_handlings_model->add(array(

                        "slipID"        => $lastInsertId,
                        "slipType"      => 'purchase',
                        "warehouseTo"   => $this->input->post("warehouse"),
                        "productID"     => $this->input->post("productID[]")[$i],
                        "productCode"   => $this->input->post("product-code[]")[$i],
                        "productTitle"  => $this->input->post("product-name[]")[$i],
                        "productUnit"   => $this->input->post("product-unit[]")[$i],
                        "quantity"      => $this->input->post("product-quantity[]")[$i],
                        "price"         => $this->input->post("product-price[]")[$i],
                        "discountValue" => $this->input->post("product-discount[]")[$i],
                        "discount"      => $this->input->post("product-discount[]")[$i],
                        "grassTotal"    => $this->input->post("product-grassTotal[]")[$i],
                        "currency"      => $this->input->post("currency"),
                        "icon"          => "fa fa-plus"
                    ));

                        $this->warehouse_products_model->addInAmount(
                            $this->input->post("productID[]")[$i],
                            $this->input->post("warehouse"),
                            $this->input->post("product-quantity[]")[$i]
                        );
                    /* Check product for notification */
                    checkProductForNotification($this->input->post("productID[]")[$i], $this->input->post("warehouse"));
                }

                if($savePurchaseProducts){
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
            redirect(base_url('purchases/add-purchase'));

        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "add";
            $viewData->pageTitle        = "Giriş Fakturası Yarat".$this->pageTitleExt;
            $viewData->header           = "Giriş Fakturası Yarat";
            $viewData->newCode          = $this->item_slips_model->generate_autoCode('IPS');
            $viewData->warehouses       = $this->warehouse_model->getAll();
            $viewData->suppliers        = $this->persons_model->getAll(array("personType"=>"supplier"));
            $viewData->requisitions     = $this->requisitions_model->getAll();
            $viewData->currency         = $this->currency_model->getAll();
            $viewData->billTypes        = $this->bill_Types_model->getAll(array("type"=>"purchase"));
            $viewData->units            = $this->units_model->getAll();
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function update_form($id){

        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "update";
        $viewData->pageTitle        = "Giriş Fakturası Redaktə Et".$this->pageTitleExt;
        $viewData->header           = "Giriş Fakturası Redaktə Et";
        $viewData->warehouses       = $this->warehouse_model->getAll();
        $viewData->suppliers        = $this->persons_model->getAll(array("personType"=>"supplier"));
        $viewData->requisitions     = $this->requisitions_model->getAll();
        $viewData->currency         = $this->currency_model->getAll();
        $viewData->billTypes        = $this->bill_Types_model->getAll(array("type"=>"purchase"));
        $viewData->units            = $this->units_model->getAll();
        $viewData->purchases        = $this->item_slips_model->get(
            array(
                "item_slips.ID" => $id
            ),
            array('item_slips.*',
                'requisitions.ID AS RID',
                'requisitions.code AS rCode'
            ),
            array(
                array(
                    "tableName"   =>'requisitions',
                    "joinColumns" =>'requisitions.ID=item_slips.requisitionID',
                    "type"        =>"LEFT"
                )
            )
        );

        $viewData->purchasesItems   = $this->item_handlings_model->getAll(
            array(
            "slipID" => $id
        ));

        if(!$viewData->purchases || !$viewData->purchasesItems):
            $viewData->result   = false;
        else: $viewData->result = true;
        endif;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function update($id){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("auto-code","Avto Kod","required|trim");
        $this->form_validation->set_rules("code","Kod","required|trim");
        $this->form_validation->set_rules("supplier","Tədarükçü","required|trim");
        $this->form_validation->set_rules("billType","Əməliyyat Tipi","required|trim");
        $this->form_validation->set_rules("currency","Məzənnə","required|trim");
        $this->form_validation->set_rules("date","Redaktə Tarixi","required|trim");
        $this->form_validation->set_rules("requisition","Tələbnamə &#8470","trim");
        $this->form_validation->set_rules("productID[]","Məhsul ID","required|trim");
        $this->form_validation->set_rules("product-code[]","Məhsul Kodu","required|trim");
        $this->form_validation->set_rules("product-name[]","Məhsul Adı","required|trim");
        $this->form_validation->set_rules("product-unit[]","Ölçü Vahidi","required|trim");
        $this->form_validation->set_rules("product-quantity[]","Məhsul Miqdarı","required|trim");
        $this->form_validation->set_rules("product-price[]","Məhsul Qiyməti","required|trim");
        $this->form_validation->set_rules("product-discount[]","Məhsul Endirimi","trim");
        $this->form_validation->set_rules("product-grassTotal[]","Yekun Qiymət","required|trim");
        $this->form_validation->set_rules("totalProductDiscount","Cəm Məhsul Endirimi","required|trim");
        $this->form_validation->set_rules("totalDiscount","Cəm Endirim","required|trim");
        $this->form_validation->set_rules("grandTotal","Yekun Qiymət","required|trim");
        $this->form_validation->set_rules("generalDiscountValue","Ümumi Endirim","trim");
        $this->form_validation->set_rules("special-1","Xüsusi Sahə-1","trim");
        $this->form_validation->set_rules("special-2","Xüsusi Sahə-2","trim");
        $this->form_validation->set_rules("note","Qeyd","trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){
            $oldItems = $this->item_handlings_model->getAll(
                array(
                    "slipID" => $id
                ));
            $decreaseAmountCheck = array();

            for ($i=0;$i<count($oldItems);$i++) {
                if ($this->warehouse_products_model->decreaseAmount(
                    $oldItems[$i]->productID,
                    $oldItems[$i]->warehouseTo,
                    $oldItems[$i]->quantity
                )){
                    $decreaseAmountCheck[] = true;
                }
                else{
                    $decreaseAmountCheck[] = false;
                }
            }

            if(!is_array(false,$decreaseAmountCheck)){

                $deleteOldData = $this->item_handlings_model->delete(
                  array(
                   "slipID" => $id
                  ));
                if($deleteOldData){
                    $updatePurchase = $this->item_slips_model->update(
                        array(
                            "ID"    => $id
                        ),
                        array(
                            "code"              => $this->input->post("code"),
                            "personID"          => $this->input->post("supplier"),
                            "billType"          => $this->input->post("billType"),
                            "generalDiscountValue" => $this->input->post("generalDiscountValue"),
                            "generalDiscount"   => $this->input->post("generalDiscountValue"),
                            "totalProductDiscount" => $this->input->post("totalProductDiscount"),
                            "TotalDiscount"     => $this->input->post("totalDiscount"),
                            "grandTotal"        => $this->input->post("grandTotal"),
                            "total"             => $this->input->post("grandTotal"),
                            "currency"          => $this->input->post("currency"),
                            "requisitionID"     => $this->input->post("requisition"),
                            "updatedAt"         => $this->input->post("date")." ".date('H:i:s'),
                            "updatedBy"         => 1,
                            "note"              => $this->input->post("note"),
                            "special1"          => $this->input->post("special-1"),
                            "special2"          => $this->input->post("special-2"),
                            "userID"            => 1
                        ));
                    if($updatePurchase){
                        $savePurchaseProducts = false;
                        for($i=0;$i<count($this->input->post('productID[]'));$i++){
                            $savePurchaseProducts = $this->item_handlings_model->add(array(

                                "slipID"    => $id,
                                "productID"     => $this->input->post("productID[]")[$i],
                                "warehouseTo"   => $this->input->post("warehouse"),
                                "productCode"   => $this->input->post("product-code[]")[$i],
                                "productTitle"  => $this->input->post("product-name[]")[$i],
                                "productUnit"   => $this->input->post("product-unit[]")[$i],
                                "quantity"      => $this->input->post("product-quantity[]")[$i],
                                "price"         => $this->input->post("product-price[]")[$i],
                                "discountValue" => $this->input->post("product-discount[]")[$i],
                                "discount"      => $this->input->post("product-discount[]")[$i],
                                "grassTotal"    => $this->input->post("product-grassTotal[]")[$i],
                                "currency"      => $this->input->post("currency"),
                                "icon"          => "fa fa-plus"
                            ));

                            $this->warehouse_products_model->addInAmount(
                                $this->input->post("productID[]")[$i],
                                $this->input->post("warehouse"),
                                $this->input->post("product-quantity[]")[$i]
                            );

                            /* Check product for notification */
                            checkProductForNotification($this->input->post("productID[]")[$i], $this->input->post("warehouse"));
                        }

                        if($savePurchaseProducts){
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
            redirect(base_url('purchases'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "update";
            $viewData->pageTitle        = "Giriş Fakturası Redaktə Et".$this->pageTitleExt;
            $viewData->header           = "Giriş Fakturası Redaktə Et";
            $viewData->warehouses       = $this->warehouse_model->getAll();
            $viewData->suppliers        = $this->persons_model->getAll(array("personType"=>"supplier"));
            $viewData->requisitions     = $this->requisitions_model->getAll();
            $viewData->currency         = $this->currency_model->getAll();
            $viewData->billTypes        = $this->bill_Types_model->getAll(array("type"=>"purchase"));
            $viewData->units            = $this->units_model->getAll();
            $viewData->purchases        = $this->item_slips_model->get(
                array(
                    "item_slips.ID" => $id
                ),
                array('item_slips.*',
                    'requisitions.ID AS RID',
                    'requisitions.code AS rCode'
                ),
                array(
                    array(
                        "tableName"   =>'requisitions',
                        "joinColumns" =>'requisitions.ID=item_slips.requisitionID',
                        "type"        =>"LEFT"
                    )
                )
            );
            $viewData->purchasesItems   = $this->item_handlings_model->getAll(
                array(
                    "slipID" => $id
                ));
            if(!$viewData->purchases || !$viewData->purchasesItems):
                $viewData->result   = false;
            else: $viewData->result = true;
            endif;
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }

    }

    public function delete($id){
        $oldItems = $this->item_handlings_model->getAll(
            array(
                "slipID" => $id
            ));

        $decreaseAmountCheck = array();

        if($oldItems){

            for ($i=0;$i<count($oldItems);$i++) {
                if ($this->warehouse_products_model->decreaseAmount(
                    $oldItems[$i]->productID,
                    $oldItems[$i]->warehouseTo,
                    $oldItems[$i]->quantity
                )){
                    $decreaseAmountCheck[] = true;
                }
                else{
                    $decreaseAmountCheck[] = false;
                }
            }

            if(!is_array(false,$decreaseAmountCheck)) {


                $deletePurchase = $this->item_slips_model->delete(
                    array(
                        "ID" => $id
                ));

                $deleteItems = $this->item_handlings_model->delete(
                    array(
                        "slipID" => $id
                    ));


                if($deletePurchase && $deleteItems){
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
        redirect(base_url('purchases'));

    }

    public function add_table_row(){
        $rowHtml  = "";
        $rowID = $this->input->post('newRowID');
        $units    = $this->units_model->getAll();
        $rowHtml .= '<tr id="items-table-row-'.$rowID.'">';
        $rowHtml .= '<td class="custom-product-td">';
        $rowHtml .= '<input type="text" required onfocus="addProduct(this)" name="product-code[]" class="form-control custom-product-input mySearch product-code">';
        $rowHtml .= '<input type="hidden" name="productID[]" class="productID">';
        /*$rowHtml .= '<input type="hidden" name="productWarehouse[]" class="productWarehouse">';*/
        $rowHtml .= '</td>';
        $rowHtml .= '<td class="custom-product-td">';
        $rowHtml .= '<input type="text" required name="product-name[]" readonly  class="form-control custom-product-input">';
        $rowHtml .= '</td>';
        $rowHtml .= '<td class="custom-product-td">';
        $rowHtml .= '<select name="product-unit[]" required class="form-control custom-product-select">';
        $rowHtml .= '<option value="">Ölçü Vahidi</option>';
        foreach ($units as $unit){
            $rowHtml .= '<option value="'.$unit->name.'">'.$unit->name.'</option>';
        }
        $rowHtml .= '</select>';
        $rowHtml .= '</td>';
        $rowHtml .= '<td class="custom-product-td"><fieldset><div class="input-group">';
        $rowHtml .= '<input onkeyup="calculateGrassTotal(this)" required type="text" name="product-quantity[]" type="text" class="form-control custom-product-input custom-touch-spin product-quantity general-touchspin" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" />';
        $rowHtml .= '</div></fieldset></td>';
        $rowHtml .= '<td class="custom-product-td"><fieldset><div class="input-group">';
        $rowHtml .= '<input onkeyup="calculateGrassTotal(this)" required type="text" name="product-price[]" type="text" class="form-control custom-product-input custom-touch-spin product-price general-touchspin" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" />';
        $rowHtml .= '</div></fieldset></td>';
        $rowHtml .= '<td class="custom-product-td"><fieldset><div class="input-group">';
        $rowHtml .= '<input type="text" onkeyup="applyDiscount(this)" name="product-discount[]" type="text" class="form-control custom-product-input custom-touch-spin product-discount general-touchspin" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" />';
        $rowHtml .= '</div></fieldset></td>';
        $rowHtml .= '<td class="custom-product-td">';
        $rowHtml .= '<input type="text" name="product-grassTotal[]" required readonly class="form-control custom-product-input product-grassTotal">';
        $rowHtml .= '</td>';
        $rowHtml .= '<td class="custom-product-td product-operation-td"><i onclick="removeRow(this)" data-belong-row-id="'.$rowID.'" class="fa fa-trash red"></i></td>';

        echo $rowHtml;
    }

    private function readCsvFile($file){

        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        if(!is_null($file) && isset($file['name']) && in_array($file['type'], $file_mimes)){

            require_once APPPATH.'third_party/phpSpreadSheet/autoload.php';

            $fileName = $file['tmp_name'];

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            $reader->setLoadAllSheets();
            $reader->setReadDataOnly(true);

            /* Read Csv file as Text */
            $directData = file_get_contents($fileName);
            $comma     = substr_count($directData,",");
            $semicolon = substr_count($directData,";");

            /* Set CSV parsing options */
            if($comma>$semicolon):
                $reader->setDelimiter(',');
            else:
                $reader->setDelimiter(';');
            endif;
            $reader->setEnclosure('"');
            $reader->setSheetIndex(0);

            $spreadsheet = $reader->load($fileName);

            $fileData = $spreadsheet->getActiveSheet()->toArray(null,false,true,true);

            return $fileData;
        }
        else{
            return false;
        }

    }

    public function importCsvFile(){

        $file = $_FILES['csvFile'];
        $result = array();
        if(!is_null($file)){
            $fileData = self::readCsvFile($file);
            if($fileData != false && is_array($fileData)){
                $returnData            = self::csv2HtmlTable($fileData);
                $returnData['header']  = "Ürünler başarıyla eklendi";
                $message               = self::makeImportCsvResultMessage($returnData);
                $result['message']     = $message;
                $result['rowHtml']     = $returnData['rowHtml'];
            }
            else{
                $returnData = array();
                $returnData['header']               = "Ürünleri eklemede sorun oluştu";
                $returnData['rowHtml']              = "";
                $returnData['comparison']           = "";
                $returnData['addedItems']           = 0;
                $returnData['undefinedItemsCount']  = 0;
                $returnData['undefinedItems']       = "";
                $returnData['totalItems']           = 0;

                $message           = self::makeImportCsvResultMessage($returnData);
                $result['message'] = $message;
            }
        }
        else{

            $returnData = array();
            $returnData['header']               = "Dosya okuma zamanı hata oluştu";
            $returnData['rowHtml']              = "";
            $returnData['comparison']           = "";
            $returnData['addedItems']           = 0;
            $returnData['undefinedItemsCount']  = 0;
            $returnData['undefinedItems']       = "";
            $returnData['totalItems']           = 0;

            $message = self::makeImportCsvResultMessage($returnData);
            $result['message'] = $message;
        }

        echo json_encode($result);
    }

    private function csv2HtmlTable($fileData){
        $rowHtml = "";
        $comparison = "";
        $result = array();
        $arrLen = count($fileData);
        $rowCounter = 1;
        $addedItems = 1;
        $totalItems = 1;
        $undefinedItemsCount = 0;
        $undefinedItems = "";
        $units    = $this->units_model->getAll();

        for($i=4;$i<=$arrLen;$i++){
            if((!empty($fileData[$i]['B']) || $fileData[$i]['B']!="") && (!empty($fileData[$i]['C']) || $fileData[$i]['C']!="") && (!empty($fileData[$i]['D']) || $fileData[$i]['D']!="")){
                $product = self::checkProductFromDB(trim($fileData[$i]['B']) );
                if($product != false){

                    $comparison .= self::makeComparison($product->ID, (float)$fileData[$i]['D']);

                    $rowHtml .= '<tr id="items-table-row-'.$rowCounter.'">';
                    $rowHtml .= '<td class="custom-product-td">';
                    $rowHtml .= '<input type="text" required onfocus="addProduct(this)" name="product-code[]" class="form-control custom-product-input mySearch product-code" value="'.$product->code.'">';
                    $rowHtml .= '<input type="hidden" name="productID[]" class="productID" value="'.$product->ID.'">';
                    /*$rowHtml .= '<input type="hidden" name="productWarehouse[]" class="productWarehouse">';*/
                    $rowHtml .= '</td>';
                    $rowHtml .= '<td class="custom-product-td">';
                    $rowHtml .= '<input type="text" required name="product-name[]" readonly  class="form-control custom-product-input" value="'.$product->title.'">';
                    $rowHtml .= '</td>';
                    $rowHtml .= '<td class="custom-product-td">';
                    $rowHtml .= '<select name="product-unit[]" required class="form-control custom-product-select">';
                    $rowHtml .= '<option value="">Ölçü Vahidi</option>';
                    foreach ($units as $unit){
                        $selected = ($unit->ID == $product->unitID)?"selected":"";
                        $rowHtml .= '<option '.$selected.' value="'.$unit->name.'">'.$unit->name.'</option>';
                    }
                    $rowHtml .= '</select>';
                    $rowHtml .= '</td>';
                    $rowHtml .= '<td class="custom-product-td"><fieldset><div class="input-group">';
                    $rowHtml .= '<input onkeyup="calculateGrassTotal(this)" required type="text" name="product-quantity[]" type="text" class="form-control custom-product-input custom-touch-spin product-quantity general-touchspin" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" value="'.$fileData[$i]['D'].'" />';
                    $rowHtml .= '</div></fieldset></td>';
                    $rowHtml .= '<td class="custom-product-td"><fieldset><div class="input-group">';
                    $rowHtml .= '<input onkeyup="calculateGrassTotal(this)" required type="text" name="product-price[]" type="text" class="form-control custom-product-input custom-touch-spin product-price general-touchspin" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" />';
                    $rowHtml .= '</div></fieldset></td>';
                    $rowHtml .= '<td class="custom-product-td"><fieldset><div class="input-group">';
                    $rowHtml .= '<input type="text" onkeyup="applyDiscount(this)" name="product-discount[]" type="text" class="form-control custom-product-input custom-touch-spin product-discount general-touchspin" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" />';
                    $rowHtml .= '</div></fieldset></td>';
                    $rowHtml .= '<td class="custom-product-td">';
                    $rowHtml .= '<input type="text" name="product-grassTotal[]" required readonly class="form-control custom-product-input product-grassTotal">';
                    $rowHtml .= '</td>';
                    $rowHtml .= '<td class="custom-product-td product-operation-td"><i onclick="removeRow(this)" data-belong-row-id="'.$rowCounter.'" class="fa fa-trash red"></i></td>';

                    $rowCounter++;
                }
                else{
                    $undefinedItemsCount++;
                    if($i==$arrLen):
                        $undefinedItems.=$fileData[$i]['B'];
                    else:
                        $undefinedItems.=$fileData[$i]['B'].', ';
                    endif;
                }
                $totalItems++;
            }

        }
        /* Prepare result */
        $addedItems = $rowCounter;
        $result['rowHtml']              = $rowHtml;
        $result['comparison']           = $comparison;
        $result['addedItems']           = $addedItems;
        $result['undefinedItemsCount']  = $undefinedItemsCount;
        $result['undefinedItems']       = $undefinedItems;
        $result['totalItems']           = $totalItems;

        return $result;
    }

    private function makeComparison($productID, $fileAmount){
        $result = "";
        $productDetails = $this->warehouse_products_model->fetchProductWithAllDetails(array(
            "wp.productID"  =>  $productID
        ));
        if($productDetails){
            foreach ($productDetails as $product){
                $result.= '<tr>';
                $result.= '<td>'.$product->code.'</td>';

                $className = ($product->netQuantity<$fileAmount)?"font-weight-bold red":"";
                $result.= '<td class="'.$className.'">'.$product->netQuantity.'</td>';

                $className = ($fileAmount<$product->netQuantity)?"font-weight-bold red":"";
                $result.= '<td class="'.$className.'">'.number_format($fileAmount,6).'</td>';

                $result.= '<td>'.$product->wName.'</td>';
                $result.= '</tr>';
            }
        }
        return $result;
    }

    private function checkProductFromDB($productCode){
        $this->load->model('products_model');
        $product = $this->products_model->get(array(
            "code"  => $productCode
        ));
        if($product){
            return $product;
        }
        else{
            return false;
        }
    }

    private function makeImportCsvResultMessage($messages){
        $message = "";
        $message .= '<h3 class="success font-weight-bold" id="header-message">'.$messages['header'].'</h3>
                    <p>
                        <span class="font-weight-bold">Dosyadaki toplam ürün sayısı: </span>  '.$messages['totalItems'].'
                    </p>
                    <p>
                        <span class="font-weight-bold">Eklenen ürün sayısı: </span> '.$messages['addedItems'].'
                    </p>
                    <p>
                        <span class="font-weight-bold">Bulunmayan ürün sayısı: </span> '.$messages['undefinedItemsCount'].'
                    </p>
                    <div class="collapse-icon accordion-icon-rotate">
                        <div id="headingCollapse12" class="card-header p-0">
                        <a data-toggle="collapse" href="#collapse12" aria-expanded="false" aria-controls="collapse12"
                           class="card-title lead collapsed">Bulunmayan ürünler listesi</a>
                    </div>
                        <div id="collapse12" role="tabpanel" aria-labelledby="headingCollapse12" class="collapse"
                         aria-expanded="false">
                        <div class="card-content">
                            <div class="card-body">
                                '.$messages['undefinedItems'].'
                            </div>
                        </div>
                    </div>
                    </div>
                    <hr>
                    <div class="collapse-icon accordion-icon-rotate">
                        <div id="headingCollapse13" class="card-header p-0">
                        <a data-toggle="collapse" href="#collapse13" aria-expanded="false" aria-controls="collapse13"
                           class="card-title lead collapsed">Farkları</a>
                    </div>
                        <div id="collapse13" role="tabpanel" aria-labelledby="headingCollapse13" class="collapse"
                         aria-expanded="false">
                        <div class="card-content">
                            <div class="card-body">
                                <table class="table full-width display nowrap table-striped table-bordered scroll-horizontal-vertical base-style">
                                    <thead>
                                        <tr>
                                            <th>Stok Kodu</th>
                                            <th>Sistemdeki Stok Miktarı</th>
                                            <th>Dosyadaki Stok Miktarı</th>
                                            <th>Depo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    '.$messages['comparison'].'
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>';
        return $message;
    }

    public function getDataTable(){
        echo $this->item_slips_model->getDataTable($where=array("slipType"=>"purchase"));
    }


}
