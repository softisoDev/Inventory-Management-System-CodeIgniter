<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Recipes_items_model extends CI_Model{

    public $tableName = "";

    public function __construct()
    {
        parent::__construct();
        $this->tableName = "recipes_items";
    }

    public function get($where = array())
    {
        return $this->db->where($where)->get($this->tableName)->row();
    }

    public function getAll($where = array(), $join = false){
        if($join):
            $this->db->select('p.ID AS pID, p.code, p.title, p.stockAmount, prx.ID AS prxID, prx.code AS prxCode, prx.name, prx.netAmount, r.premixID, r.warehouseID, r.amount, r.unitID');
            $this->db->from($this->tableName. ' AS r');
            $this->db->join('products AS p','r.productID = p.ID','LEFT');
            $this->db->join('premixes AS prx','r.premixID = prx.ID','LEFT');
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