<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_model extends CI_Model{

    public $tableName = "";
    public $prefix    = "";

    public function __construct()
    {
        parent::__construct();
        $this->tableName = "sales";
        $this->prefix    = "MÇF";
    }

    public function getDataTable(){

        $this->load->library('datatables');

        $this->datatables->select('sales.ID, sales.autoCode, sales.code AS Pcode, warehouse.name AS Wname, customers.name AS Cname, sales.total, sales.currency, requisitions.code AS Rcode, sales.date AS Pdate, sales.userID as SUid');
        $this->datatables->from($this->tableName);
        $this->datatables->join('warehouse', 'sales.warehouseID=warehouse.ID', 'left');
        $this->datatables->join('customers', 'sales.customerID=customers.ID', 'left');
        $this->datatables->join('requisitions', 'sales.requisitionID=requisitions.ID', 'left');
        return $this->datatables->generate('json');
    }

    public function generate_autoCode(){
        $this->load->helper('tools_helper');
        $columns = array("autoCode");
        $oders = array(
            "autoCode"=>"DESC"
        );

        return generate_new_autoCode($this->prefix,$this->tableName,$columns,array(),$oders);
    }

    public function get($where=array(), $columns=array('*'),$joinTables = array()){
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