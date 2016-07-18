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
        if( isset($this->document[_COLLECTION_FIELD_]) && isset($this->document[_ACTION_]) ){
			$result = $this->submit();
        }else{
			if(isset($this->document[_REQUEST_])){
				$request = $this->document[_REQUEST_];
				unset($this->document[_REQUEST_]);
				
				if( method_exists(get_class(), $request) ){
					$result = $this->$request();
				}else{
					$error = 'ERROR: Does not exist request '.strtoupper($request);
					$result = $this->model->_error($error);
				}
			}else if(isset($_FILES['files']['name'][0])){
				include_once('uploads.php');
				$uploads = new uploads();
				
				$result = $uploads->upload($this->model);
			}else{			
				$error = 'ERROR: Does not exist request.';
				$result = $this->model->_error($error);
			}
		}
		echo json_encode($result);
    }
    
    private function submit(){
		$user = $this->model->_getUser();
		
        $collectionName = $this->document[_COLLECTION_FIELD_];
		unset($this->document[_COLLECTION_FIELD_]);
		
		$action = $this->document[_ACTION_];
		unset($this->document[_ACTION_]);
		
		if( (is_array($user['groups']) && in_array('administrators', $user['groups'])) || $user['groups']=='administrators' ){
			//thuc thi ROLE Administrators
			if($action=='create'){
				$document = $this->model->documentCheckAdmin($collectionName, $this->document);
				$result = $this->model->create($collectionName, $document);
			}else if($action=='update'){
				if(isset($this->document['_id'])){
					$filter = array('_id'=>$this->document['_id']);
					unset($this->document['_id']);
				}else{
					return array('result'=>false, 'message'=>'Không truyền ID cập nhật.');
				}
				$document = $this->model->documentCheckAdmin($collectionName, $this->document);
				$result = $this->model->update($collectionName, $document, $filter);
			}else if($action=='read'){
				if(isset($this->document['_filter'])){
					$filter = $this->document['_filter'];
				}else{
					$filter = array();
				}
				$result = $this->model->find($collectionName, $filter);
			}else if($action=='delete'){
				if(!isset($this->document['where'])){
					return array('result'=>false, 'message'=>'Không truyền điều kiện để xóa.');
				}
				$where = $this->document['where'];
				$result = $this->model->remove($collectionName, $where);
			}else{
				$arr = array('result'=>false, 'message'=>'ERROR: '.$action);
				return $arr;
			}
		}else{
			//check authorityCollection
			//Create var fields
			$allowCollection = $this->model->_authorityCollection($user, $collectionName, $fields);
			if($allowCollection==false){
				$arr = array('result'=>false, 'message'=>'Collection: Access deny');
				return $arr;
			}
		
			//kiem tra quyền thực thi
			if(!isset($allowCollection[$action]) || $allowCollection[$action]==0){
				$arr = array('result'=>false, 'message'=>'Document: Access deny');
				return $arr;
			}
		
			//check authorityFields
			$allowFields = $this->model->_authorityFields($user, $fields);
			if(is_bool($allowFields)){
				$arr = array('result'=>false, 'message'=>'Fields: Access deny');
				return $arr;
			}
			
			//thuc thi
			if($action=='create'){
				$document = $this->model->_documentCheck($fields, $this->document, $error);
				if($document==false){
					$arr = array('result'=>false, 'message'=>'Document: Incorrect', 'error'=>$error);
					return $arr;
				}
				$result = $this->model->create($collectionName, $document);
			}else if($action=='update'){
				$document = $this->model->_documentCheck($fields, $this->document, $error);
				if($document==false){
					$arr = array('result'=>false, 'message'=>'Document: Incorrect', 'error'=>$error);
					return $arr;
				}
				
				if(!isset($document['_filter'])){
					$filter = array('_id'=>$document['_id']);
				}else{
					$filter = $document['_filter'];
					unset($document['_filter']);
				}
				
				$result = $this->model->update($collectionName, $document, $filter);
			}else if($action=='read'){
				if(isset($this->document['filter'])){
					$filter = $this->document['filter'];
				}else{
					$filter = array();
				}
				$result = $this->model->read($collectionName, $filter);
			}else if($action=='delete'){
				$result = $this->model->delete($collectionName, $this->document);
			}else{
				$arr = array('result'=>false, 'message'=>'ERROR: '.$action);
				return $arr;
			}
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
	
	//BID
	private function updateBID(){
		if(!isset($_POST['_id'])){
			$result = array('result'=>false, 'message'=>'<p class="error" style="padding:20px 50px"><b>ERROR: ID</b></p>');
			return $result;
		}
		$idProduct = $_POST['_id'];
		
		$filter = array(
			'where' => array('_id'=>$idProduct),
			'pretty' => array('_id'=>0, 'price_current'=>1, 'price_step'=>1, 'datetime'=>1),
		);
		$dataProduct = $this->model->findOne(_POSTS_, $filter);
		$price_current = $dataProduct['price_current'];
		
		$filter = array(
			'where' => array('product'=>$idProduct),
			'sort' => array('_id'=>-1),
			'limit' => 1,
		);
		$dataUserBID = $this->model->find('user_bid', $filter);
		$name = '';
		if(isset($dataUserBID['name'])){
			$name = $dataUserBID['name'];
		}
		
		//check time
		if(isset($dataProduct['datetime']) && $dataProduct['datetime']>0){
			$dateEnd = time() - $dataProduct['datetime'];
		}else if(!isset($dataProduct['datetime']) || $dataProduct['datetime']==0){
			$dateEnd = 0;
			$document = array();
			$document['datetime'] = time();
			$filter = array('_id'=>$idProduct);
			$this->model->update(_POSTS_, $document, $filter);
		}
		
		if($dateEnd>=30 && count($dataUserBID)>0){
			$message = 'Chúc mừng <b>'.strtoupper($name).'</b> dành chiến thắng với giá đấu <b>'.number_format($price_current, 0, ',', '.').'</b>';
			$result = array('result'=>true, 'message'=>$message);
			return $result;
		}else if($dateEnd>=30 && count($dataUserBID)==0){
			$message = 'Phiên đấu giá đã đóng với <b>0</b> lượt BID.';
			$result = array('result'=>true, 'message'=>$message);
			return $result;
		}
		//end check time
		
		if(isset($_POST['bid']) && isset($_SESSION['users'])){
			$user = $_SESSION['users'];
			$name = $user['name'];
			if(isset($dataUserBID['user']) && $dataUserBID['user']==$user['_id']){
				$result = array('result'=>false, 'message'=>'<p class="message" style="padding:20px 50px"><b>MESSAGE: Hiện tại giá bạn là cao nhất</b></p>');
				return $result;
			}
			
			$price_current = $price_current + $dataProduct['price_step'];
			
			$document = array();
			$document['price_current'] = $price_current;
			$document['datetime'] = time();
			$filter = array('_id'=>$idProduct);
			$this->model->update(_POSTS_, $document, $filter);
			
			$document = array(
				'product' => $idProduct,
				'user' => $user['_id'],
				'name' => $name,
				'price' => $price_current,
				'date' => time(),
			);
			$this->model->create('user_bid', $document);
		}
		
		$dateEnd = 30 - $dateEnd;
		$result = array('result'=>true, 'message'=>'Success!', 'data'=>array(
			'price' => number_format($price_current, 0, ',', '.'),
			'name' => $name,
			'time' => $dateEnd,
		));
		return $result;
	}
	//end BID
}

$control = new ajax();