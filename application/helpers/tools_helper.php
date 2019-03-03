<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function generate_new_autoCode($prefix, $tableName, $columns=array('*'), $where=array(), $orders=array()){
    $ci =& get_instance();
    $ci->db->select($columns);
    $ci->db->from($tableName);
    $ci->db->where($where);
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