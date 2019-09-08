<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function generate_new_autoCode($prefix, $tableName, $columns=array('*'), $where=array(), $orders=array()){
    $ci =& get_instance();
    $ci->db->select($columns);
    $ci->db->from($tableName);
    $ci->db->like($where);
    if(!empty($orders) || $orders!=null):
        foreach ($orders as $column => $orderBy){
            $ci->db->order_by($column,$orderBy);
        }
    endif;

    $data = $ci->db->get()->row();
    if($data):
        $columnName = $columns[0];
        $data = $data->$columnName;
        $splitData = explode('-',$data);
        $convet2Int = intval($splitData[1]);
        $convet2Int+=1;
        $generateCode = sprintf("%06d",$convet2Int);
        return $prefix.'-'.$generateCode;
    else:
        $createCode  = sprintf("%06d",1);
        return $prefix.'-'.$createCode;
    endif;
}

function getControllersList(){
    $CI =& get_instance();
    $controllers = array();
    $CI->load->helper('file');
    $files = get_dir_file_info(APPPATH."controllers",false);
    return array_keys($files);
}

function get_active_user(){

    $ci = &get_instance();

    $user = $ci->session->userdata("user");

    if($user)
        return $user;
    else
        return false;
}

function convertToKg($productID, $unitID,$weight){
    $CI =& get_instance();
    $CI->load->model('products_model');
    $getProduct = $CI->products_model->get(array(
       "ID" => $productID
    ));
    if(!is_null($getProduct) && $getProduct){
        if($getProduct->unitID == $unitID && $getProduct->unitID == 4){
            return $weight;
        }
        switch ($unitID){
            case 5:
                return sprintf('%.6f', floatval($weight/1000000));
                break;
            case 7:
                return $weight/1000;
                break;
            default:
                return $weight;
                break;
        }
    }
    return false;
}

function checkProductForNotification($productID, $warehouseID){
    $CI =& get_instance();

    $CI->load->model('notifications_model');
    $CI->load->model('notification_types_model');
    $CI->load->model('warehouse_products_model');

    $checkedData = $CI->warehouse_products_model->checkStockAmount($productID, $warehouseID);

    if($checkedData && !is_null($checkedData)){

        $getNotifType = $CI->notification_types_model->get(array(
            "ID" => 1
        ));

        $content = "<strong>Məhsul kodu: </strong> {$checkedData->code}<br/>";
        $content .= "<strong>Məhsulun adı: </strong>: {$checkedData->title}<br/>";
        $content .= "<strong>Anbar: </strong>: {$checkedData->name}<br/>";
        $content .= "<strong>Qalan miqdar: </strong>: {$checkedData->netQuantity}<br/>";

        $CI->notifications_model->add(array(
            "title"         =>  $getNotifType->name,
            "content"       =>  $content,
            "level"         =>  "medium",
            "createdAt"    =>   date("Y-m-d H:i:s")
        ));
    }
}