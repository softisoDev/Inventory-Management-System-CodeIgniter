<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Premixes_items_model extends CI_Model{

    public $tableName = "";

    public function __construct()
    {
        parent::__construct();
        $this->tableName = "premixes_items";
    }

    public function get($where = array())
    {
        return $this->db->where($where)->get($this->tableName)->row();
    }

    public function getAll($where = array(), $join = false){
        if($join):
            $this->db->select('p.ID AS pID, p.code, p.title, p.stockAmount, pr.warehouseID, u.name, pr.amount, pr.ratio, pr.unitID');
            $this->db->from($this->tableName. ' AS pr');
            $this->db->join('products AS p','pr.productID = p.ID');
            $this->db->join('units AS u', 'p.unitID = u.ID');
            $this->db->where($where);

            return $this->db->get()->result();
        else:
            return $this->db->where($where)->get($this->tableName)->result();
        endif;
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