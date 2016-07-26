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
			return array('result'=>false, 'message'=>'Không tìm thấy user');
		}
		
		if(!isset($this->document['password'])){
			return array('result'=>false, 'message'=>'Không tìm thấy password');
		}
		
		if($this->model->_checkEmail($user) != false){
			$field = 'email';
		}else{
			$field = 'username';
		}
		
		$filter = array(
			'where' => array($field=>$user, 'status'=>true),
			'pretty' => array('_id'=>0, 'salt'=>1),
		);
		$salt = $this->model->findOne('users', $filter);
		
		if(count($salt)==0){
			return array('result'=>false, 'message'=>'Không tìm thấy user.');
		}
		
		$password = $this->document['password'] . $salt;
		$password = $this->model->_password($password);
		
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
			return array('result'=>false, 'message'=>'User hoặc password chưa đúng');
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
			$this->document['is_admin'] = false;
			$this->document['status'] = true;
			
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
	
	private function viewForm(){
		$html = ob_start();
		echo '<div class="frm-register">';
		include_once('views/web_login.php');
		include_once('libraries/login_facebook.php');
		include_once('libraries/login_google.php');
		echo '</div>';
		$html = ob_get_clean();
		
		$result = array('result'=>true, 'data'=>$html);
		return $result;
	}
	
	private function register(){
		if(!isset($this->document['email']) || !isset($this->document['password']) || !isset($this->document['password_confirm'])){
			return array('result'=>false, 'message'=>'ERROR: Thông tin đăng ký không đầy đủ.');
		}
		
		$email = $this->model->_checkEmail($this->document['email']);
		if($email==false){
			return array('result'=>false, 'message'=>'ERROR: Email chưa đúng');
		}
		
		$error = array();
		
		$password = $this->document['password'];
		if(strlen($password) < 6){
			$error[] = 'Mật khẩu phải hơn 6 ký tự';
		}
		
		$passwordConfirm = $this->document['password_confirm'];
		if($password != $passwordConfirm){
			$error[] = 'Mật khẩu nhắc lại chưa đúng';
		}  
		
		//mật khẩu khó
		//if( !preg_match("#[0-9]+#", $password) ) $error[] = 'Mật khẩu phải chứa ít nhất 1 ký tự <b>SỐ</b>';
		//if( !preg_match("#[a-z]+#", $password) ) $error[] = 'Mật khẩu phải chứa ít nhất 1 ký tự <b>THƯỜNG</b>';
		//if( !preg_match("#[A-Z]+#", $password) ) $error[] = 'Mật khẩu phải chứa ít nhất 1 ký tự <b>HOA</b>';
		
		if(count($error)==0){
			$filter = array(
				'where' => array('email'=>$email),
				'pretty' => array('_id'=>1),
			);
			$data = $this->model->findOne('users', $filter);
			if(count($data)==0){
				$name = explode('@', $email);
				$name = strtoupper($name[0]);
				
				$salt = $this->model->_randomString(5);
				
				$document = array(
					'name' => $name,
					'email' => $email,
					'password' => $this->model->_password($password.$salt),
					'salt' => $salt,
					'groups' => 'users',
					'is_admin' => false,
					'status' => true,
				);
				$this->model->create('users', $document);
				
				//tự động đăng nhập
				$document = array('email'=>$email, 'password'=>$password);
				$this->document = $document;
				return $this->login();
			}else{
				return array('result'=>false, 'message'=>'Email này đã được đăng ký.');
			}
		}else{
			return array('result'=>false, 'message'=>'ERROR: Mật khẩu chưa đạt yêu cầu', 'data'=>$error);
		}
	}
}