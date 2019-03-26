<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouse_products_model extends CI_Model{

    public $tableName = "";
    public $prefix    = "";

    public function __construct()
    {
        parent::__construct();
        $this->tableName = "warehouse_products";
    }

    public function increaseAmount($productId, $warehouse, $amount){
        $checkExsisting = self::get(array("productID" => $productId,"warehouseID"=>$warehouse));
        if($checkExsisting):

            $this->db->set('productIn', 'productIn+'.$amount, FALSE);
            $this->db->set('netQuantity', 'netQuantity+'.$amount, FALSE);
            $this->db->where(array(
                "productID" => $productId,
                "warehouseID"=>$warehouse
            ));
            return $this->db->update($this->tableName);

        else:
            return self::add(array("productID" => $productId,"warehouseID"=>$warehouse,"productIn"=>$amount,"netQuantity"=>$amount));
        endif;
    }

    public function addInAmount($productId, $warehouse, $amount){
        $checkExsisting = self::get(array("productID" => $productId,"warehouseID"=>$warehouse));
        if($checkExsisting):

            $this->db->set('productIn', 'productIn+'.$amount, FALSE);
            $this->db->set('netQuantity', 'netQuantity+'.$amount, FALSE);
            $this->db->where(array(
                "productID" => $productId,
                "warehouseID"=>$warehouse
            ));
            return $this->db->update($this->tableName);

        else:
            return self::add(array("productID" => $productId,"warehouseID"=>$warehouse,"productIn"=>$amount,"netQuantity"=>$amount));
        endif;
    }

    public function decreaseAmount($productId, $warehouse, $amount){
        $this->db->set('productIn', 'productIn-'.$amount, FALSE);
        $this->db->set('netQuantity', 'netQuantity-'.$amount, FALSE);
        $this->db->where(array(
            "productID" => $productId,
            "warehouseID"=>$warehouse
        ));
        return $this->db->update($this->tableName);
    }

    public function get($where=array()){
        return $this->db->where($where)->get($this->tableName)->row();
    }

    public function add($data){
        return $this->db->insert($this->tableName,$data);
    }

    public function getAll($where = array()){
        return $this->db->where($where)->get($this->tableName)->result();
    }

    public function update($where=array(),$data=array()){
        return $this->db->where($where)->update($this->tableName,$data);
    }

    public function delete($where=array()){
        return $this->db->where($where)->delete($this->tableName);
    }

}