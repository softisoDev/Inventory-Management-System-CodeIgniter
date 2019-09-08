<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Item_slips_model extends CI_Model{

    public $tableName = "";
    public $prefix    = "";

    public function __construct()
    {
        parent::__construct();
        $this->tableName = "item_slips";
        $this->prefix    = "ISS";
    }

    public function getDataTable($where=array()){

        $this->load->library('datatables');

        $this->datatables->select('is.ID, is.autoCode, is.code AS Pcode, p.fullName, CONCAT(is.total," ", is.currency) AS slipTotal, requisitions.code AS Rcode, is.date AS Pdate, u.name AS userName');
        $this->datatables->from($this->tableName.' AS is');
        $this->datatables->join('persons AS p', 'is.personID=p.ID', 'left');
        $this->datatables->join('requisitions', 'is.requisitionID=requisitions.ID', 'left');
        $this->datatables->join('users AS u', 'is.userID=u.ID');

        $this->datatables->where($where);

        return $this->datatables->generate('json');
    }


    public function generate_autoCode($prefix){
        $this->load->helper('tools_helper');
        $columns = array("autoCode");
        $oders = array(
            "autoCode"=>"DESC"
        );

        return generate_new_autoCode($prefix,$this->tableName,$columns,array("autoCode"=>$prefix),$oders);
    }

    public function get($where=array(), $columns=array('*'),$joinTables = array()){
        $this->db->select($columns);
        $this->db->from($this->tableName);
        if(!empty($joinTables)):foreach ($joinTables as $join){$this->db->join($join['tableName'],$join['joinColumns'],$join['type']);} endif;
        $this->db->where($where);
        return $this->db->get()->row();
    }

    public function getSales($where=array(), $columns=array('*'),$joinTables = array()){
        $this->db->select($columns);
        $this->db->from($this->tableName);
        if(!empty($joinTables)):foreach ($joinTables as $join){$this->db->join($join['tableName'],$join['joinColumns'],$join['type']);} endif;
        $this->db->where($where);
        return $this->db->get()->row();
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