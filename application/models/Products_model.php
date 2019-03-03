<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model{

    public $tableName = "";
    public $prefix    = "";

    public function __construct()
    {
        parent::__construct();
        $this->tableName = "products";
        $this->prefix    = "PR";
    }

    public function getDataTable(){

        $this->load->library('datatables');

        $this->datatables->select('products.ID, autoCode, code, title, brands.name AS brandName, categories.name AS categoryName, units.shortName, cost, price, price2,  VAT, barcode, barcode2, stockAmount, criticStockAmount, shelfNo, products.createdAt,  special1, special2, products.isActive AS productStatus, products.updatedAt, products.description, changableCode');
        $this->datatables->from('products');
        $this->datatables->join('categories', 'products.categoryID=categories.ID', 'left');
        $this->datatables->join('brands', 'products.brandID=brands.ID', 'left');
        $this->datatables->join('units', 'products.unitID=units.ID', 'left');
        return $this->datatables->generate('json');
    }

    public function generate_autoCode(){
        $this->load->helper('tools_helper');
        $columns = array("autoCode");
        $oders = array(
            "autoCode"=>"DESC"
        );

        return generate_new_autoCode($this->prefix,$this->tableName,$columns,array(),$oders);
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