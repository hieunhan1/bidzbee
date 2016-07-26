<?php
class ajax{
	private $model;
    private $document;
    
    public function __construct(){
		include_once('models/modelAjax.php');
		$this->model = new modelAjax;
		
		$this->data();
        $this->handle();
    }
    
    private function data(){
        if(isset($_POST)){
            $data = $_POST;
        }else if(isset($_GET)){
            $data = $_GET;
        }else{
			echo json_encode( $this->model->_error() );
			return false;
		}
		
		$this->document = $data;
    }
    
	private function handle(){
        if(isset($this->document[_ACTION_]) && !isset($this->document[_REQUEST_])){
			$result = $this->submit();
        }else if(isset($this->document[_REQUEST_])){
			$request = $this->document[_REQUEST_];
			unset($this->document[_REQUEST_]);
			
			if( method_exists(get_class(), $request) ){
				$result = $this->$request();
			}else{
				$error = 'ERROR: Does not exist request '.strtoupper($request);
				$result = $this->model->_error($error);
			}
		}else if(isset($_FILES['files']['name'][0])){
			$result = $this->uploads();
		}else{		
			$error = 'ERROR: Does not exist request.';
			$result = $this->model->_error($error);
		}
		
		echo json_encode($result);
    }
    
    private function submit(){
		$user = $this->model->_getUser();
		
		$action = $this->document[_ACTION_];
		unset($this->document[_ACTION_]);
		
		if( isset($user['groups']) && ((is_array($user['groups']) && in_array('administrators', $user['groups'])) || $user['groups']=='administrators') ){
			if(isset($this->document[_COLLECTION_FIELD_])){
				$collection = $this->document[_COLLECTION_FIELD_];
				unset($this->document[_COLLECTION_FIELD_]);
			}else{
				//get pages
				$filter = array(
					'where' => array('name' => $user['pageCurrent']),
					'pretty' => array('collection'=>1),
				);
				$dataPages = $this->model->findOne(_PAGES_, $filter);
				
				//check collection
				if(isset($dataPages['collection'])){
					$collection = $dataPages['collection'];
				}else{
					$arr = array('result'=>false, 'message'=>'ERROR: Pages không tồn tại Collection');
					return $arr;
				}
			}
			
			//thuc thi ROLE Administrators
			if($action=='create'){
				$document = $this->model->documentCheckAdmin($collection, $this->document);
				$result = $this->model->create($collection, $document);
			}else if($action=='update'){
				if(isset($this->document['_id'])){
					$filter = array('_id'=>$this->document['_id']);
					unset($this->document['_id']);
				}else{
					return array('result'=>false, 'message'=>'ERROR: Không truyền ID cập nhật.');
				}
				$document = $this->model->documentCheckAdmin($collection, $this->document);
				$result = $this->model->update($collection, $document, $filter);
			}else if($action=='read'){
				if(isset($this->document['_filter'])){
					$filter = $this->document['_filter'];
				}else{
					$filter = array();
				}
				$result = $this->model->find($collection, $filter);
			}else if($action=='delete'){
				if(!isset($this->document['_id'])){
					return array('result'=>false, 'message'=>'ERROR: Không truyền điều kiện để xóa.');
				}
				
				$result = $this->model->remove($collection, $this->document);
			}else{
				$arr = array('result'=>false, 'message'=>'ERROR: Không tồn tại '.strtoupper($action).' này!');
				return $arr;
			}
		}else if(isset($user['groups'])){
			//get pages
			$filter = array(
				'where' => array('name' => $user['pageCurrent']),
			);
			$dataPages = $this->model->findOne(_PAGES_, $filter);
			
			//check collection
			$collection = '';
			if(isset($dataPages['collection'])){
				$collection = $dataPages['collection'];
			}else{
				$arr = array('result'=>false, 'message'=>'ERROR: Pages không tồn tại Collection');
				return $arr;
			}
			
			//authority collection
			$authCollection = array();
			if(isset($dataPages['authority'])){
				$authCollection = $dataPages['authority'];
			}
			$allowCollection = $this->model->_authorityCheck($user, $authCollection);
			if(!isset($allowCollection[$action]) || $allowCollection[$action]==0){
				$arr = array('result'=>false, 'message'=>'ERROR: Collection access deny');
				return $arr;
			}
		
			//authority fields
			$fields = array();
			if(isset($dataPages['fields'])){
				$fields = $dataPages['fields'];
			}else{
				$arr = array('result'=>false, 'message'=>'ERROR: Field empty.');
				return $arr;
			}
			$allowFields = $this->model->_authorityFields($user, $fields);
			if(is_array($allowFields)){
				foreach($allowFields as $name=>$allow){
					if(isset($allow[$action]) && $allow[$action]==0){
						$arr = array('result'=>false, 'message'=>'ERROR: Field '.strtoupper($name).' access deny');
						return $arr;
					}
				}
			}
			
			//thuc thi
			if(!isset($dataPages['']))
			if($action=='create'){
				$document = $this->model->_documentCheck($fields, $this->document, $error);
				if($document==false){
					$arr = array('result'=>false, 'message'=>'ERROR: Create incorrect', 'error'=>$error);
					return $arr;
				}
				$result = $this->model->create($collection, $document);
			}else if($action=='update'){
				$document = $this->model->_documentCheck($fields, $this->document, $error);
				if($document==false){
					$arr = array('result'=>false, 'message'=>'ERROR: Update incorrect', 'error'=>$error);
					return $arr;
				}
				
				if(isset($document['_id'])){
					$filter = array('_id'=>$document['_id']);
					unset($document['_id']);
				}else{
					return array('result'=>false, 'message'=>'ERROR: Không truyền ID cập nhật.');
				}
				
				$result = $this->model->update($collection, $document, $filter);
			}else if($action=='read'){
				if(isset($this->document['_filter'])){
					$filter = $this->document['_filter'];
				}else{
					$filter = array();
				}
				$result = $this->model->find($collection, $filter);
			}else if($action=='delete'){
				if(!isset($this->document['_id'])){
					return array('result'=>false, 'message'=>'ERROR: Không truyền điều kiện để xóa.');
				}
				
				$result = $this->model->remove($collection, $this->document);
			}else{
				$arr = array('result'=>false, 'message'=>'ERROR: Không tồn tại '.strtoupper($action).' này!');
				return $arr;
			}
		}else{
			return array('result'=>false, 'message'=>'ERROR: Phiên làm việc đã hết, vui lòng ấn F5 đăng nhập.');
		}
		
		if(is_bool($result) && $result==false){
			$arr = array('result'=>false, 'message'=>'ERROR: '.$action);
			return $arr;
		}
		
		$result = array(
			'result' => true,
			'message' => 'Success!',
			'data' => $result,
		);
		return $result;
    }
	
	// USERS
	private function users(){
		include_once('users.php');
		$users = new users();
		$users = $users->handle($this->model, $this->document);
		return $users;
	}
	//END USERS
	
	//ACTION UPLOAD
	private function uploads(){
		$user = $this->model->_getUser();
		if( !isset($user['groups']) ){
			return false;
		}
		
		//get pages
		$filter = array(
			'where' => array('name' => $user['pageCurrent']),
			'pretty' => array('collection'=>1, 'authority'=>1),
		);
		$dataPages = $this->model->findOne(_PAGES_, $filter);
		
		//check collection
		$collection = '';
		if(isset($dataPages['collection'])){
			$collection = $dataPages['collection'];
		}else{
			$arr = array('result'=>false, 'message'=>'ERROR: Pages không tồn tại Collection');
			return $arr;
		}
		
		if( (is_array($user['groups']) && !in_array('administrators', $user['groups'])) || $user['groups']!='administrators' ){
			//authority collection
			$authCollection = array();
			if(isset($dataPages['authority'])){
				$authCollection = $dataPages['authority'];
			}
			$allowCollection = $this->model->_authorityCheck($user, $authCollection);
			if(!isset($allowCollection['create']) || $allowCollection['create']==0){
				$arr = array('result'=>false, 'message'=>'ERROR: Collection access deny');
				return $arr;
			}
		}
		
		include_once('uploads.php');
		$uploads = new uploads();
		
		return $uploads->upload($this->model);
	}
	
	private function actionUpload(){
		include_once('uploads.php');
		$uploads = new uploads();
		
		$result = $uploads->uploadAction($this->model, $this->document);
		return $result;
	}
	//END ACTION UPLOAD
	
	//BID
	private function BID(){
		include_once('bid.php');
		$bid = new bid();
		$result = $bid->handle($this->model, $this->document);
		return $result;
	}
	//end BID
	
	//loadPages
	public function loadPages(){
		if(isset($this->document['id'])){
			include_once('libraries/simple_html_dom.php');
			
			$link = $_SERVER['HTTP_HOST'].'/cp_admin/pages/?id='.$this->document['id'];
			$html = file_get_html($link);
			//$html = $html->find('#'.$tags, 0)->innertext;
			
			return $html;
		}else{
			return false;
		}
	}
	//end loadPages
}

$control = new ajax();