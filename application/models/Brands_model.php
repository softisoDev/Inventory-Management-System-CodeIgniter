<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Brands_model extends CI_Model{

    public $tableName = "";

    public function __construct()
    {
        parent::__construct();
        $this->tableName = "brands";
    }

    public function getDataTable($where=array()){

        $this->load->library('datatables');

        $this->datatables->select('ID, name, description');
        $this->datatables->from($this->tableName);

        $this->datatables->where($where);

        return $this->datatables->generate('json');
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