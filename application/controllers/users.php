<?php
class users{
	private $model;
	private $document;
	
	public function handle($model, $document){
		//get model
		$this->model = $model;
		
		//get action
		if(!isset($document[_ACTION_])){
			return array('result'=>false, 'message'=>'ERROR: Không tìm thấy hành động.');
		}
		$action = trim($document[_ACTION_]);
		unset($document[_ACTION_]);
		$this->document = $document;
		
		//gọi hàm
		if( method_exists(get_class(), $action) ){
			return $this->$action();
		}else{
			return array('result'=>false, 'message'=>'ERROR: Không tìm thấy hành động '.strtoupper($action));
		}
	}
	
	private function login(){
		if(isset($this->document['username'])){
			$user = $this->document['username'];
		}else if($this->document['email']){
			$user = $this->document['email'];
		}else{
			return array('result'=>false, 'message'=>'ERROR: Không tìm thấy user');
		}
		
		if(!isset($this->document['password'])){
			return array('result'=>false, 'message'=>'ERROR: Không tìm thấy password');
		}
		$password = $this->model->_password($this->document['password']);
		
		if($this->model->_checkEmail($user) != false){
			$field = 'email';
		}else{
			$field = 'username';
		}
		
		$filter = array(
			'where' => array($field=>$user, 'password'=>$password, 'status'=>true),
			'pretty' => array('name'=>1, 'email'=>1, 'username'=>1, 'img'=>1, 'date_expiration'=>1, 'is_admin'=>1, 'groups'=>1),
		);
		$result = $this->model->findOne('users', $filter);
		
		if($result){
			if(isset($result['is_admin']) && $result['is_admin']==true){
				$_SESSION['admin'] = $result;
				$arr = array('result'=>true, 'message'=>'Success!');
			}else{
				$_SESSION['users'] = $result;
				$arr = array('result'=>true, 'message'=>'Success!', 'url'=>'http://'.$_SERVER['HTTP_HOST']);
			}
			
			return $arr;
		}else{
			return array('result'=>false, 'message'=>'ERROR: Không tìm thấy user và password');
		}
	}
	
	private function loginThirdParty(){
		if(!isset($this->document['email'])){
			return array('result'=>false, 'message'=>'ERROR: Dữ liệu không hợp lệ');
		}
		
		$email = $this->model->_checkEmail($this->document['email']);
		if($email == false){
			return array('result'=>false, 'message'=>'ERROR: Email không hợp lệ');
		}
		
		$filter = array(
			'where' => array('email'=>$email),
			'pretty' => array('name'=>1, 'email'=>1, 'username'=>1, 'img'=>1, 'date_expiration'=>1, 'is_admin'=>1, 'group'=>1),
		);
		$result = $this->model->findOne('users', $filter);
		if(count($result)==0){
			$this->document['groups'] = 'users';
			$this->document['register'] = date(_DATETIME_);
			$this->document['is_admin'] = false;
			
			//check document
			$document = $this->model->documentCheckAdmin('users', $this->document);
			
			//create user
			$result = $this->model->create('users', $document);
			if($result!=false){
				$result = $this->model->findOne('users', $filter);
			}
		}
		
		$_SESSION['users'] = $result;
		$arr = array('result'=>true, 'message'=>'Success!');
		return $arr;
	}
	
	private function logout(){
		if(!isset($this->document['session']) || $this->document['session']==''){
			session_destroy();
			return array('result'=>true, 'message'=>'Success!');
		}else{
			if(isset($_SESSION[$this->document['session']])){
				unset($_SESSION[$this->document['session']]);
				return array('result'=>true, 'message'=>'Success!');
			}else{
				return array('result'=>false, 'message'=>'ERROR: Không tìm thấy session yêu cầu');
			}
		}
	}
}