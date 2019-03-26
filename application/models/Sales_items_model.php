<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_items_model extends CI_Model{

    public $tableName = "";
    public $prefix    = "";

    public function __construct()
    {
        parent::__construct();
        $this->tableName = "sales_items";
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