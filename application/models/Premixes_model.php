<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Premixes_model extends CI_Model{

    public $tableName = "";
    public $prefix    = "";

    public function __construct()
    {
        parent::__construct();
        $this->tableName = "premixes";
        $this->prefix    = "PMX";
    }

    public function getDataTable(){

        $this->load->library('datatables');

        $this->datatables->select('p.ID, p.autoCode, p.code, p.name, p.netAmount, u.name AS unitName');
        $this->datatables->from($this->tableName.' AS p');
        $this->datatables->join('units AS u', 'u.ID=p.unitID');

        return $this->datatables->generate('json');
    }

    public function generate_autoCode(){

        $this->load->helper('tools_helper');
        $columns = array("autoCode");
        $oders = array(            "autoCode"=>"DESC"
        );
        return generate_new_autoCode($this->prefix,$this->tableName,$columns,array(),$oders);
    }

    public function decreaseAmount($premixID, $amount){

        $this->db->set('netAmount', 'netAmount-'.$amount, FALSE);
        $this->db->where(array(
            "ID" => $premixID,
        ));
        return $this->db->update($this->tableName);
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