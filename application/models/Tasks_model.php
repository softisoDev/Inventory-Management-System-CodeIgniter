<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks_model extends CI_Model{

    public $tableName = "";
    public $prefix    = "";

    public function __construct()
    {
        parent::__construct();
        $this->tableName = "tasks";
        $this->prefix    = "SP";
    }

    public function getDataTable($where=array()){

        $this->load->library('datatables');

        $this->datatables->select('t.ID, t.autoCode, t.name AS tName, t.startDate, t.endDate, r.title, m.name AS mName, ct.name AS ctName,  t.description, t.isDone, t.isActive');
        $this->datatables->from($this->tableName.' AS t');

        $this->datatables->join('recipes AS r', 't.recipeID=r.ID', 'inner');
        $this->datatables->join('machines AS m', 't.machineID=m.ID', 'inner');
        $this->datatables->join('cigarette_types AS ct', 't.ctID=ct.ID', 'inner');

        $this->datatables->where($where);

        return $this->datatables->generate('json');
    }

    public function generate_autoCode($prefix){
        $this->load->helper('tools_helper');
        $columns = array("autoCode");
        $oders = array(
            "autoCode"=>"DESC"
        );

        return generate_new_autoCode($prefix,$this->tableName,$columns,array('autoCode'=>$prefix),$oders);
    }

    public function get($where=array(), $full=false){
        if($full){
            $this->db->select('t.ID, t.name AS tName, t.startDate, t.endDate, r.title, r.ID AS rID, m.name AS mName, ct.name AS ctName, ct.expTobac, LOWER(u.name) AS unitName, t.description');
            $this->db->from($this->tableName.' AS t');

            $this->db->join('recipes AS r', 't.recipeID=r.ID', 'inner');
            $this->db->join('machines AS m', 't.machineID=m.ID', 'inner');
            $this->db->join('cigarette_types AS ct', 't.ctID=ct.ID', 'inner');
            $this->db->join('units AS u', 'u.ID=ct.unitID', 'inner');

            $this->db->where($where);

            return $this->db->get()->row();
        }
        else{
            return $this->db->where($where)->get($this->tableName)->row();
        }
    }

    public function add($data){
        return $this->db->insert($this->tableName,$data);
    }

    public function getAll($where = array(), $full = false){
        if($full){
            $this->db->select('t.ID, t.name AS tName, t.startDate, t.endDate, r.title, m.name AS mName, ct.name AS ctName,  t.description');
            $this->db->from($this->tableName);

            $this->db->join('recipes AS r', 't.recipeID=r.ID', 'inner');
            $this->db->join('machines AS m', 't.machineID=m.ID', 'inner');
            $this->db->join('cigarette_types AS ct', 't.ctID=ct.ID', 'inner');

            $this->db->where($where);

            return $this->db->result();
        }
        else{
            return $this->db->where($where)->get($this->tableName)->result();
        }
    }

    public function update($where=array(),$data=array()){
        return $this->db->where($where)->update($this->tableName,$data);
    }

    public function delete($where=array()){
        return $this->db->where($where)->delete($this->tableName);
    }

}