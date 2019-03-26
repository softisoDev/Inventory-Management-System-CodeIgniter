<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Requisitions_model extends CI_Model{

    public $tableName = "";

    public function __construct()
    {
        parent::__construct();
        $this->tableName = "requisitions";
    }

    public function get($where = array())
    {
        return $this->db->where($where)->get($this->tableName)->row();
    }

    public function getAll($where = array(),$like = array()){
        return $this->db->where($where)->or_like($like)->get($this->tableName)->result();
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