<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Recipes_model extends CI_Model{

    public $tableName = "";
    public $prefix    = "";

    public function __construct()
    {
        parent::__construct();
        $this->tableName = "recipes";
        $this->prefix    = "RCP";
    }

    public function getDataTable(){

        $this->load->library('datatables');

        $this->datatables->select('r.ID, autoCode, code, title, DATE(r.createdAt)');
        $this->datatables->from($this->tableName.' AS r');

        return $this->datatables->generate('json');
    }

    public function generate_autoCode(){

        $this->load->helper('tools_helper');
        $columns = array("autoCode");
        $oders = array(            "autoCode"=>"DESC"
        );
        return generate_new_autoCode($this->prefix,$this->tableName,$columns,array(),$oders);
    }


    public function get($where = array())
    {
        return $this->db->where($where)->get($this->tableName)->row();
    }

    public function getAll($where = array()){
        return $this->db->where($where)->get($this->tableName)->result();
    }

    public function add($data = array()){
        return $this->db->insert($this->tableName,$data);
    }

    public function update($where = array(),$data = array()){
        return $this->db->where($where)->update($this->tableName,$data);
    }

    public function delete($where = array()){
        return $this->db->where($where)->delete($this->tableName);
    }
}