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

    public function addOutAmount($productId, $warehouse, $amount){
        $checkExsisting = self::get(array("productID" => $productId,"warehouseID"=>$warehouse));
        if($checkExsisting):

            $this->db->set('productOut', 'productOut+'.$amount, FALSE);
            $this->db->set('netQuantity', 'netQuantity-'.$amount, FALSE);
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

    public function decreaseOutAmount($productID, $warehouse, $amount){
        $this->db->set('productOut', 'productOut-'.$amount, FALSE);
        $this->db->set('netQuantity', 'netQuantity+'.$amount, FALSE);
        $this->db->where(array(
            "productID" => $productID,
            "warehouseID"=>$warehouse
        ));

        return $this->db->update($this->tableName);
    }

    public function checkStockAmount($productID, $warehouseID){
        $this->db->select('p.code, p.title, w.name, wp.netQuantity');
        $this->db->from($this->tableName.' AS wp');

        $this->db->join('products AS p','p.ID=wp.productID');
        $this->db->join('warehouse AS w','wp.warehouseID=w.ID');

        $this->db->where("wp.netQuantity < p.criticStockAmount");
        $this->db->where("wp.productID",$productID);
        $this->db->where("wp.warehouseID",$warehouseID);

        return $this->db->get()->row();
    }

    public function fetchCriticStockAmountProducts(){
        $this->db->select('p.code, p.title, w.name, wp.netQuantity');
        $this->db->from($this->tableName.' AS wp');

        $this->db->join('products AS p','p.ID=wp.productID');
        $this->db->join('warehouse AS w','wp.warehouseID=w.ID');

        $where = "wp.netQuantity < p.criticStockAmount";
        $this->db->where($where);

        return $this->db->get()->result();
    }

    public function fetchProductWithAllDetails($where = array()){
        $this->db->select('wp.ID AS wID, wp.*, p.*,w.name AS wName, w.*');
        $this->db->from($this->tableName.' AS wp');

        $this->db->join('products AS p','p.ID=wp.productID');
        $this->db->join('warehouse AS w','wp.warehouseID=w.ID');

        $this->db->where($where);

        return $this->db->get()->result();

    }

    public function getWhereIn($columnName, $where=array()){
        return $this->db->where_in($columnName,$where)->get($this->tableName)->result();
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