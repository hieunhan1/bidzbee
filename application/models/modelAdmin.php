<?php
include_once('modelDB.php');
class modelAdmin extends modelDB{
    private $db;
    
	public function __construct(){
		$this->db = $this->_connectDatabase();
	}
	
	public function find($collection, $filter=array()){
		$collection = $this->_select($this->db, $collection);
		$result = $this->_find($collection, $filter);
		return $result;
	}
	
	public function findOne($collection, $filter=array()){
		$collection = $this->_select($this->db, $collection);
		$result = $this->_findOne($collection, $filter);
		return $result;
	}
	
	public function findCount($collection, $where=array()){
		$collection = $this->_select($this->db, $collection);
		return $this->_count($collection, $where);
	}
}