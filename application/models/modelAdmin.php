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
	
	public function catalogData(){
		$collection = $this->_select($this->db, _CONTROL_);
		$arr = array(
			'pretty' => array('_id'=>0, 'name'=>1, 'label'=>1, 'authority'=>1),
			'sort' => array('name'=>1),
		);
		
		$result = $this->_find($collection, $arr);
		
		return $result;
	}
	
	public function pageCheck($page, &$collectionInfo){
		$result = array();
		
		$collection = $this->_select($this->db, _CONTROL_);
		$where = array('name'=>$page);
		$collectionInfo = $this->_findOne($collection, $where);
		if(count($collectionInfo) == 0){
			$arr = array('result'=>false, 'message'=>'ERROR: Không tìm thấy collection.');
			return $arr;
		}
		
		if($page!='' && $page!=_ADMIN_CATALOG_ && $page!=_CONTROL_){
			$collection = $this->_select($this->db, _ADMIN_CATALOG_);
			$where = array('url'=>$page);
			$pretty = array('_id'=>0);
			$result = $this->_findOne($collection, $where, $pretty);
			if(count($result) == 0){
				$arr = array('result'=>false, 'message'=>'ERROR: Không tìm thấy URL "'.$page.'" trong '._ADMIN_CATALOG_);
				return $arr;
			}
		}
		
		return $result;
	}
	
	public function pageDataList($collection, &$totalDataList){
		$colControl = $this->_select($this->db, _CONTROL_);
		
		$collection = $this->_select($this->db, $collection);
		
		$totalDataList = $this->_count($collection);
		$filter = array(
			//'where' => '',
			//'pretty' => '',
			//'limit' => '',
			//'skip' => '',
		);
		
		$result = $this->_find($collection, $filter);
		return $result;
	}
}