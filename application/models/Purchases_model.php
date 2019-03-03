<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchases_model extends CI_Model{

    public $tableName = "";
    public $prefix    = "";

    public function __construct()
    {
        parent::__construct();
        $this->tableName = "purchases";
        $this->prefix    = "MGF";
    }

    public function getProductsTable(){

        $this->load->library('datatables');

        $this->datatables->select('*');
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