<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class sales extends CI_Controller{

    public $viewFolder   = "";
    public $pageTitle    = "";
    public $pageTitleExt = "";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder   = "sales_v";
        $this->pageTitle    = "Məhsullar";
        $this->pageTitleExt = PageTitleExt;
        $this->load->model('sales_model');
        $this->load->model('sales_items_model');
        $this->load->model('warehouse_products_model');
        $this->load->model('bill_Types_model');
        $this->load->model('payment_Types_model');
        $this->load->model('warehouse_model');
        $this->load->model('customers_model');
        $this->load->model('requisitions_model');
        $this->load->model('currency_model');
        $this->load->model('units_model');
    }

    public function index(){
        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "list";
        $viewData->pageTitle        = $this->pageTitle.$this->pageTitleExt;
        $viewData->header           = "Çıxış Fakturaları";

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function new_form(){

        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "add";
        $viewData->pageTitle        = "Çıxış Fakturası Yarat".$this->pageTitleExt;
        $viewData->header           = "Çıxış Fakturası Yarat";
        $viewData->newCode          = $this->sales_model->generate_autoCode();
        $viewData->warehouses       = $this->warehouse_model->getAll();
        $viewData->customers        = $this->customers_model->getAll();
        $viewData->requisitions     = $this->requisitions_model->getAll();
        $viewData->currency         = $this->currency_model->getAll();
        $viewData->billTypes        = $this->bill_Types_model->getAll(array("type"=>"sale"));
        $viewData->units            = $this->units_model->getAll();
        $viewData->paymentTypes     = $this->payment_Types_model->getAll();

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function save(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("auto-code","Avto Kod","required|trim");
        $this->form_validation->set_rules("code","Kod","required|trim");
        $this->form_validation->set_rules("warehouse","Anbar","required|trim");
        $this->form_validation->set_rules("customer","Müştəri","required|trim");
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
        $this->form_validation->set_rules("vat","ƏDV","trim");
        $this->form_validation->set_rules("totalVAT","Total ƏDV","trim");
        $this->form_validation->set_rules("grandTotal","Yekun Qiymət","required|trim");
        $this->form_validation->set_rules("generalDiscountValue","Ümumi Endirim","trim");
        $this->form_validation->set_rules("waybill","Faktura İrsaliye","trim");
        $this->form_validation->set_rules("receivedBy","Təhvil Alan","trim");
        $this->form_validation->set_rules("special-1","Xüsusi Sahə-1","trim");
        $this->form_validation->set_rules("special-2","Xüsusi Sahə-2","trim");
        $this->form_validation->set_rules("note","Qeyd","trim");

        $this->form_validation->set_message(array(
            "required" => "{field} boş buraxıla bilməz!"
        ));

        $checkValidation = $this->form_validation->run();

        if($checkValidation){

            $savesale = $this->sales_model->add(array(
                "autoCode"          => $this->input->post("auto-code"),
                "code"              => $this->input->post("code"),
                "warehouseID"       => $this->input->post("warehouse"),
                "customerID"        => $this->input->post("customer"),
                "billType "         => $this->input->post("billType"),
                "generalDiscountValue" => $this->input->post("generalDiscountValue"),
                "generalDiscount"   => $this->input->post("generalDiscountValue"),
                "totalProductDiscount" => $this->input->post("totalProductDiscount"),
                "TotalDiscount"     => $this->input->post("totalDiscount"),
                "VATvalue"          => $this->input->post("vat"),
                "totalVAT"          => $this->input->post("totalVAT"),
                "grandTotal"        => $this->input->post("grandTotal"),
                "total"             => $this->input->post("grandTotal"),
                "currency"          => $this->input->post("currency"),
                "requisitionID"     => $this->input->post("requisition"),
                "date"              => $this->input->post("date")." ".date('H:i:s'),
                "note"              => $this->input->post("note"),
                "special1"          => $this->input->post("special-1"),
                "special2"          => $this->input->post("special-2"),
                "icon"              => 'fa fa-plus',
                "userID"            => 1,
                "billerID"          => 1
            ));

            if($savesale){
                $lastInsertId = $this->db->insert_id();
                $savesaleProducts = false;

                for($i=0;$i<count($this->input->post('productID[]'));$i++){
                    $savesaleProducts = $this->sales_items_model->add(array(

                        "saleID"    => $lastInsertId,
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
                }

                if($savesaleProducts){
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
            redirect(base_url('sales/add-sale'));

        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "add";
            $viewData->pageTitle        = "Çıxış Fakturası Yarat".$this->pageTitleExt;
            $viewData->header           = "Çıxış Fakturası Yarat";
            $viewData->newCode          = $this->sales_model->generate_autoCode();
            $viewData->warehouses       = $this->warehouse_model->getAll();
            $viewData->suppliers        = $this->suppliers_model->getAll();
            $viewData->requisitions     = $this->requisitions_model->getAll();
            $viewData->currency         = $this->currency_model->getAll();
            $viewData->billTypes        = $this->bill_Types_model->getAll(array("type"=>"sale"));
            $viewData->units            = $this->units_model->getAll();
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
    }

    public function update_form($id){

        $viewData = new stdClass();
        $viewData->viewFolder       = $this->viewFolder;
        $viewData->subViewFolder    = "update";
        $viewData->pageTitle        = "Çıxış Fakturası Redaktə Et".$this->pageTitleExt;
        $viewData->header           = "Çıxış Fakturası Redaktə Et";
        $viewData->warehouses       = $this->warehouse_model->getAll();
        $viewData->suppliers        = $this->suppliers_model->getAll();
        $viewData->requisitions     = $this->requisitions_model->getAll();
        $viewData->currency         = $this->currency_model->getAll();
        $viewData->billTypes        = $this->bill_Types_model->getAll(array("type"=>"sale"));
        $viewData->units            = $this->units_model->getAll();
        $viewData->sales        = $this->sales_model->get(
            array(
                "sales.ID" => $id
            ),
            array('sales.*',
                'requisitions.ID AS RID',
                'requisitions.code AS rCode'
            ),
            array(
                array(
                    "tableName"   =>'requisitions',
                    "joinColumns" =>'requisitions.ID=sales.requisitionID',
                    "type"        =>"LEFT"
                )
            )
        );

        $viewData->salesItems   = $this->sales_items_model->getAll(
            array(
            "saleID" => $id
        ));

        if(!$viewData->sales || !$viewData->salesItems):
            $viewData->result   = false;
        else: $viewData->result = true;
        endif;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }

    public function update($id){

        $this->load->library('form_validation');

        $this->form_validation->set_rules("auto-code","Avto Kod","required|trim");
        $this->form_validation->set_rules("code","Kod","required|trim");
        $this->form_validation->set_rules("warehouse","Anbar","required|trim");
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
            $oldItems = $this->sales_items_model->getAll(
                array(
                    "saleID" => $id
                ));
            $decreaseAmountCheck = array();

            for ($i=0;$i<count($oldItems);$i++) {
                if ($this->warehouse_products_model->decreaseAmount(
                    $oldItems[$i]->productID,
                    $this->input->post("warehouse"),
                    $oldItems[$i]->quantity
                )){
                    $decreaseAmountCheck[] = true;
                }
                else{
                    $decreaseAmountCheck[] = false;
                }
            }

            if(!is_array(false,$decreaseAmountCheck)){

                $deleteOldData = $this->sales_items_model->delete(
                  array(
                   "saleID" => $id
                  ));
                if($deleteOldData){
                    $updatesale = $this->sales_model->update(
                        array(
                            "ID"    => $id
                        ),
                        array(
                            "code"              => $this->input->post("code"),
                            "supplierID"        => $this->input->post("supplier"),
                            "billType "         => $this->input->post("billType"),
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
                    if($updatesale){
                        $savesaleProducts = false;
                        for($i=0;$i<count($this->input->post('productID[]'));$i++){
                            $savesaleProducts = $this->sales_items_model->add(array(

                                "saleID"    => $id,
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
                        }

                        if($savesaleProducts){
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
            redirect(base_url('sales'));
        }
        else{

            $viewData = new stdClass();
            $viewData->viewFolder       = $this->viewFolder;
            $viewData->subViewFolder    = "update";
            $viewData->pageTitle        = "Çıxış Fakturası Redaktə Et".$this->pageTitleExt;
            $viewData->header           = "Çıxış Fakturası Redaktə Et";
            $viewData->warehouses       = $this->warehouse_model->getAll();
            $viewData->suppliers        = $this->suppliers_model->getAll();
            $viewData->requisitions     = $this->requisitions_model->getAll();
            $viewData->currency         = $this->currency_model->getAll();
            $viewData->billTypes        = $this->bill_Types_model->getAll(array("type"=>"sale"));
            $viewData->units            = $this->units_model->getAll();
            $viewData->sales        = $this->sales_model->get(
                array(
                    "sales.ID" => $id
                ),
                array('sales.*',
                    'requisitions.ID AS RID',
                    'requisitions.code AS rCode'
                ),
                array(
                    array(
                        "tableName"   =>'requisitions',
                        "joinColumns" =>'requisitions.ID=sales.requisitionID',
                        "type"        =>"LEFT"
                    )
                )
            );
            $viewData->salesItems   = $this->sales_items_model->getAll(
                array(
                    "saleID" => $id
                ));
            if(!$viewData->sales || !$viewData->salesItems):
                $viewData->result   = false;
            else: $viewData->result = true;
            endif;
            $viewData->form_error       = true;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }

    }

    public function delete($id){
        $oldItems = $this->sales_items_model->getAll(
            array(
                "saleID" => $id
            ));
        $fetchsale = $this->sales_model->get(array(
            "ID"    => $id
        ));
        $warehousID = $fetchsale->warehouseID;

        $decreaseAmountCheck = array();

        if($fetchsale && $oldItems){

            for ($i=0;$i<count($oldItems);$i++) {
                if ($this->warehouse_products_model->decreaseAmount(
                    $oldItems[$i]->productID,
                    $warehousID,
                    $oldItems[$i]->quantity
                )){
                    $decreaseAmountCheck[] = true;
                }
                else{
                    $decreaseAmountCheck[] = false;
                }
            }

            if(!is_array(false,$decreaseAmountCheck)) {


                $deletesale = $this->sales_model->delete(
                    array(
                        "ID" => $id
                ));

                $deleteItems = $this->sales_items_model->delete(
                    array(
                        "saleID" => $id
                    ));


                if($deletesale && $deleteItems){
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
        redirect(base_url('sales'));

    }

    public function add_table_row(){
        $rowHtml  = "";
        $rowID = $this->input->post('newRowID');
        $units    = $this->units_model->getAll();
        $rowHtml .= '<tr id="items-table-row-'.$rowID.'">';
        $rowHtml .= '<td class="custom-product-td">';
        $rowHtml .= '<input type="text" required onfocus="addProduct(this)" name="product-code[]" class="form-control custom-product-input mySearch product-code">';
        $rowHtml .= '<input type="hidden" name="productID[]" class="productID">';
        $rowHtml .= '</td>';
        $rowHtml .= '<td class="custom-product-td">';
        $rowHtml .= '<input type="text" required name="product-name[]" readonly  class="form-control custom-product-input">';
        $rowHtml .= '</td>';
        $rowHtml .= '<td class="custom-product-td">';
        $rowHtml .= '<select name="product-unit[]" required class="form-control custom-product-select">';
        $rowHtml .= '<option value="">Ölçü Vahidi</option>';
        foreach ($units as $unit){
            $rowHtml .= '<option value="'.$unit->shortName.'">'.$unit->name.'</option>';
        }
        $rowHtml .= '</select>';
        $rowHtml .= '</td>';
        $rowHtml .= '<td class="custom-product-td"><fieldset><div class="input-group">';
        $rowHtml .= '<input onkeyup="calculateGrassTotal(this)" required type="text" name="product-quantity[]" type="text" class="form-control custom-product-input custom-touch-spin product-quantity sale-bill general-touchspin" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" />';
        $rowHtml .= '<input class="max-quantity" id="max-quantity" name="max-quantity" type="hidden">';
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

    public function add_first_row(){
        $rowHtml  = "";
        $units    = $this->units_model->getAll();
        $rowHtml .= '<tr id="items-table-row-1">';
        $rowHtml .= '<td class="custom-product-td">';
        $rowHtml .= '<input type="text" required onfocus="addProduct(this)" name="product-code[]" class="form-control custom-product-input mySearch product-code">';
        $rowHtml .= '<input type="hidden" name="productID[]" class="productID">';
        $rowHtml .= '</td>';
        $rowHtml .= '<td class="custom-product-td">';
        $rowHtml .= '<input type="text" required name="product-name[]" readonly  class="form-control custom-product-input">';
        $rowHtml .= '</td>';
        $rowHtml .= '<td class="custom-product-td">';
        $rowHtml .= '<select name="product-unit[]" required class="form-control custom-product-select">';
        $rowHtml .= '<option value="">Ölçü Vahidi</option>';
        foreach ($units as $unit){
            $rowHtml .= '<option value="'.$unit->shortName.'">'.$unit->name.'</option>';
        }
        $rowHtml .= '</select>';
        $rowHtml .= '</td>';
        $rowHtml .= '<td class="custom-product-td"><fieldset><div class="input-group">';
        $rowHtml .= '<input onkeyup="calculateGrassTotal(this)" required type="text" name="product-quantity[]" type="text" class="form-control custom-product-input custom-touch-spin product-quantity sale-bill general-touchspin" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" />';
        $rowHtml .= '<input class="max-quantity" id="max-quantity" name="max-quantity" type="hidden">';
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
        $rowHtml .= '<td class="custom-product-td product-operation-td"><i class="fa fa-trash red"></i></td>';

        echo $rowHtml;
    }

    public function getDataTable(){
        echo $this->sales_model->getDataTable();
    }

}