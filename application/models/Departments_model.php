<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Departments_model extends CI_Model{

    public $tableName = "";

    public function __construct()
    {
        parent::__construct();
        $this->tableName = "departments";
    }

    public function getDataTable($where=array()){

        $this->load->library('datatables');

        $this->datatables->select('d.ID, d.name, b.name AS bName, d.email, d.telephone, d.description');
        $this->datatables->from($this->tableName.' AS d');

        $this->datatables->join('branch AS b', 'd.branchID = b.ID');

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