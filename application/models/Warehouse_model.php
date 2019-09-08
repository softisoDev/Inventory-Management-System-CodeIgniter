<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouse_model extends CI_Model{

    public $tableName = "";

    public function __construct()
    {
        parent::__construct();
        $this->tableName = "warehouse";
    }

    public function getDataTable($where=array()){

        $this->load->library('datatables');

        $this->datatables->select('w.ID, b.name AS bName, d.name AS dName, w.name AS wName, personInCharge, w.createdAt, w.description');
        $this->datatables->from($this->tableName.' AS w');

        $this->datatables->join('branch AS b', 'w.branchID = b.ID');
        $this->datatables->join('departments AS d', 'w.departmentID = d.ID');

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