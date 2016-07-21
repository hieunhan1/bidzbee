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
		
		if( (is_array($user['groups']) && in_array('administrators', $user['groups'])) || $user['groups']=='administrators' ){
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
		}else{
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
	
	private function getProduct($_id){
		$filter = array(
			'where' => array('_id'=>$_id),
			'pretty' => array(
				'_id'=>0,
				'price_cost'=>1,
				'price_start'=>1,
				'price_step'=>1,
				'price_current'=>1,
				'count_bid'=>1,
				'date_bid'=>1
			),
		);
		$data = $this->model->findOne(_POSTS_, $filter);
		if($data){
			return $data;
		}else{
			return false;
		}
	}
	
	private function BID(){
		//get product
		if(isset($this->document['_id'])){
			$idProduct = $this->document['_id'];
			$dataProduct = $this->getProduct($idProduct);
			if($dataProduct==false){
				return array('result'=>false, 'message'=>'ERROR: Không tìm thấy ID '.$idProduct);
			}
		}else{
			return array('result'=>false, 'message'=>'ERROR: _ID?');
		}
		
		//check date BID
		$dateCurrent = time();
		if(isset($dataProduct['date_bid'])){
			$date_bid = $dataProduct['date_bid']->sec;
			
			//$dateCurrent = 1468050032;
			//$date_bid    = 1468050001;
			
			if($date_bid<=$dateCurrent && $date_bid+30>=$dateCurrent){
				//được BID
				return array('result'=>false, 'message'=>'được BID');
			}else if(($date_bid<=$dateCurrent) && ($date_bid+30<=$dateCurrent)){
				//đóng BID
				return array('result'=>false, 'message'=>'đóng BID');
			}else{
				return array('result'=>false, 'message'=>'ERROR: Sản phẩm chưa lên sàn.');
			}
		}else{
			return array('result'=>false, 'message'=>'ERROR: Sản phẩm không lên sàn.');
		}
		
		
		
		
		
		
		return true;
		
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
		
		
		
		$result = array('result'=>true, 'message'=>'Success!', 'data'=>$this->document);
		//echo json_encode($result);
		return $result;
	}
}

$control = new ajax();