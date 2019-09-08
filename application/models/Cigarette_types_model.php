<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cigarette_types_model extends CI_Model{

    public $tableName = "";

    public function __construct()
    {
        parent::__construct();
        $this->tableName = "cigarette_types";
    }

    public function getDataTable($where=array()){

        $this->load->library('datatables');

        $this->datatables->select('ct.ID, ct.name, ct.expTobac, CONCAT(u.name, " (",LOWER(u.shortName),")") AS unitName');
        $this->datatables->from($this->tableName.' AS ct');
        $this->datatables->join('units AS u','u.ID=ct.unitID');
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