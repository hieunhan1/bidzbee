<?php
include_once('modelDB.php');
class modelAjax extends modelDB{
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
	
	public function exportDocument($document, $fields=NULL){
		$documentNew = array();
		if(is_array($fields)){
			foreach($fields as $name=>$type){
				if(isset($document[$name])){
					$data = $document[$name];
					if(!is_array($data)){
						if($type=='text'){
							$documentNew[$name] = trim($data);
						}else if($type=='number'){
							if(!preg_match('/\./', $data)){
								settype($data, 'int');
							}else{
								settype($data, 'float');
							}
							$documentNew[$name] = $data;
						}else if($type=='bool'){
							if($data==1 || $data=='true'){
								$data = true;
							}else{
								$data = false;
							}
							$documentNew[$name] = $data;
						}else if($type=='date'){
							if($this->_validateDate($data, _DATETIME_)==true){
								$data = $this->_dateObject($data);
							}else{
								$data = '';
							}
							$documentNew[$name] = $data;
						}else if($type=='pass'){
							$documentNew[$name] = $this->_password($data);
						}else{
							if(is_numeric($data)){
								if(!preg_match('/\./', $data)){
									settype($data, 'int');
								}else{
									settype($data, 'float');
								}
								$documentNew[$name] = $data;
							}else if($data=='true'){
								$data == true;
								$documentNew[$name] = $data;
							}else if($data=='false'){
								$data == false;
								$documentNew[$name] = $data;
							}else{
								$documentNew[$name] = trim($data);
							}
						}
					}else{
						$documentNew[$name] = $this->exportDocument($data);
					}
				}
			}
		}else{
			foreach($document as $name=>$data){
				if(!is_array($data)){
					if(is_numeric($data)){
						if(!preg_match('/\./', $data)){
							settype($data, 'int');
						}else{
							settype($data, 'float');
						}
						$documentNew[$name] = $data;
					}else if($data=='true'){
						$data = true;
						$documentNew[$name] = $data;
					}else if($data=='false'){
						$data = false;
						$documentNew[$name] = $data;
					}else{
						$documentNew[$name] = trim($data);
					}
				}else{
					$documentNew[$name] = $this->exportDocument($data);
				}
			}
		}
		
		return $documentNew;
	}
	
	public function documentCheckAdmin($collection, $document){
		//check tồn tại collection
		if($collection != _COLLECTION_){
			$filter = array(
				'where' => array('name'=>$collection),
				'pretty' => array('_id'=>0, 'fields'=>1),
			);
			$collection = $this->_select($this->db, _COLLECTION_);
			$fields = $this->_findOne($collection, $filter);
			if(count($fields) == 0){
				return false;
			}
		}else{
			$fields = NULL;
		}
		
		//kiểm tra export document
		$documentNew = $this->exportDocument($document, $fields);
		
		return $documentNew;
	}
	
	public function create($collection, $document){
		try{
			$collection = $this->_select($this->db, $collection);
			$result = $this->_insert($collection, $document);
			return $result;
		}catch (Exception $e){
			return false;
		}
	}
	
	public function update($collection, $document, $filter){
		try{
			if($collection != _COLLECTION_){
				$collection = $this->_select($this->db, $collection);
				$result = $this->_update($collection, $document, $filter);
			}else{
				if(isset($filter['_id'])){
					$document['_id'] = $filter['_id'];
				}
				$collection = $this->_select($this->db, $collection);
				$result = $this->_save($collection, $document);
			}
			return $result;
		}catch (Exception $e){
			return false;
		}
	}
	
	public function remove($collection, $document){
		try{
			$collection = $this->_select($this->db, $collection);
			$result = $this->_remove($collection, $document);
			return $result;
		}catch (Exception $e){
			return false;
		}
	}
	
	public function templates($document){
		if( isset($document['fields']) && isset($document['code']) ){
			$fields = $document['fields'];
			$string = $document['code'];
			
			$data = array(
				'title' => 'Hướng dẫn đăng bài',
				'img' => 'public/images/123.jpg',
				'name' => 'Hướng dẫn',
				'description' => 'Mô tả ngắn',
			);
			
			$string = $this->_replace($fields, $data, $string);
			
			return $string;
		}else{
			return false;
		}
	}
}