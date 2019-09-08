<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_handlings_model extends CI_Model{

    public $tableName = "";
    public $prefix    = "";

    public function __construct()
    {
        parent::__construct();
        $this->tableName = "item_handlings";
    }

    public function getDataTable($where=array()){
        $this->load->library('datatables');

        $this->datatables->select('ih.ID AS ihID, ih.icon AS ihIcon, ih.productCode, ih.productTitle, is.code AS isCode, is.date, w1.name AS warehouseToName, w2.name AS warehouseFromName, ih.quantity, ih.productUnit, CONCAT(ih.price," ", ih.currency) AS price');
        $this->datatables->from($this->tableName.' AS ih');

        $this->datatables->join('item_slips AS is', 'is.ID=ih.slipID', 'inner');
        $this->datatables->join('warehouse AS w1', 'is.warehouseTo=w1.ID', 'left');
        $this->datatables->join('warehouse AS w2', 'is.warehouseFrom=w2.ID', 'left');

        $this->datatables->where('ih.productCode', $where['productCode']);
        $this->datatables->where("(DATE(is.date) BETWEEN '".$where['startDate']."' AND '".$where['endDate']."')");

        $this->db->order_by('is.date ASC');

        return $this->datatables->generate('json');
    }

    public function get($where=array()){
        return $this->db->where($where)->get($this->tableName)->row();
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