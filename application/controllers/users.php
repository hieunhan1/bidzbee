<?php
class users{
	private $model;
	private $document;
	
	public function handle($model, $document){
		//get model
		$this->model = $model;
		
		//get action
		if(!isset($document[_ACTION_])){
			$this->loginFail('Users: not action');
			return array('result'=>false, 'message'=>'ERROR: Không tìm thấy hành động.');
		}
		$action = trim($document[_ACTION_]);
		unset($document[_ACTION_]);
		$this->document = $document;
		
		//gọi hàm
		if( method_exists(get_class(), $action) ){
			return $this->$action();
		}else{
			$this->loginFail('Users: not function '.strtoupper($action));
			return array('result'=>false, 'message'=>'ERROR: Không tìm thấy hành động '.strtoupper($action));
		}
	}
	
	private function login(){
		if(isset($this->document['username'])){
			$user = $this->document['username'];
		}else if($this->document['email']){
			$user = $this->document['email'];
		}else{
			$this->loginFail('Login: Username or email empty');
			return array('result'=>false, 'message'=>'Không tìm thấy user');
		}
		
		if(!isset($this->document['password'])){
			$this->loginFail('Login: Password empty');
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
			$this->loginFail('Login: Username incorrect');
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
				$arr = array('result'=>true, 'message'=>'Success!', 'url'=>_DOMAIN_);
			}
			
			return $arr;
		}else{
			$this->loginFail('Login: Password incorrect');
			return array('result'=>false, 'message'=>'Password chưa đúng');
		}
	}
	
	private function loginThirdParty(){
		if(!isset($this->document['email'])){
			$this->loginFail('Login third party: Email empty');
			return array('result'=>false, 'message'=>'ERROR: Dữ liệu không hợp lệ');
		}
		
		$email = $this->model->_checkEmail($this->document['email']);
		if($email == false){
			$this->loginFail('Login third party: Email incorrect');
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
			$this->loginFail('Register: email or password empty');
			return array('result'=>false, 'message'=>'ERROR: Thông tin đăng ký không đầy đủ.');
		}
		
		$email = $this->model->_checkEmail($this->document['email']);
		if($email==false){
			$this->loginFail('Register: email incorrect');
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
				$this->loginFail('Register: email registered');
				return array('result'=>false, 'message'=>'Email này đã được đăng ký.');
			}
		}else{
			$this->loginFail('Register: password not qualified');
			return array('result'=>false, 'message'=>'ERROR: Mật khẩu chưa đạt yêu cầu', 'data'=>$error);
		}
	}
	
	private function updateAccount(){
		$user = $this->model->_getUser();
		if($user==''){
			$this->loginFail('Update account: not signed');
			return array('result'=>false, 'message'=>'ERROR: Vui lòng đăng nhập');
		}
		
		//check password_new and password_confirm
		if( !isset($this->document['password_new']) || !isset($this->document['password_confirm']) ){
			$this->loginFail('Update account: password new or password confirm empty');
			return array('result'=>false, 'message'=>'ERROR: Thông tin mật khẩu mới chưa đúng.');
		}
		$password_new = $this->document['password_new'];
		$password_confirm = $this->document['password_confirm'];
		if( strlen($password_new)<6 || $password_new!=$password_confirm ){
			$this->loginFail('Update account: password new incorrect');
			return array('result'=>false, 'message'=>'ERROR: Mật khẩu mới chưa đúng.');
		}
		
		//changePassword
		if(isset($user['username']) && $user['username']!=''){
			return $this->changePassword($user, $password_new);
		}else{ //create username and password
			return $this->createUsernamePassword($user, $password_new);
		}
	}
	
	private function changePassword($user, $password_new){
		if(isset($this->document['password']) && strlen($this->document['password'])>=6){
			$password = $this->document['password'];
			if($password==$password_new){
				$this->loginFail('Change password: Other current password to a new password.');
				return array('result'=>false, 'message'=>'Mật khẩu hiện tại phải khác mật khẩu mới.');
			}
			
			$filter = array(
				'where' => array('_id'=>$user['_id']),
				'pretty' => array('_id'=>0, 'salt'=>1),
			);
			$salt = $this->model->findOne('users', $filter);
		
			$password = $this->model->_password($password.$salt);
			$filter = array(
				'where' => array('_id'=>$user['_id'], 'password'=>$password),
				'pretty' => array('salt'=>1, 'log_change_pass'=>1),
			);
			$data = $this->model->findOne('users', $filter);
			if($data){
				$document = array(
					'password' => $this->model->_password($password_new.$salt),
				);
				
				if(!isset($data['log_change_pass'])){
					$document['log_change_pass'] = array();
					$document['log_change_pass'][] = array(
						'datetime' => $this->model->_dateObject(),
						'password_old' => $password,
					);
				}else{
					$log_change_pass = $data['log_change_pass'];
					array_push($log_change_pass, array(
							'datetime' => $this->model->_dateObject(),
							'password_old' => $password,
						)
					);
					$document['log_change_pass'] = $log_change_pass;
				}
				
				$filter = array(
					'_id'=>$user['_id'],
				);
				$this->model->update('users', $document, $filter);
				return array('result'=>true, 'message'=>'Thay đổi mật khẩu thành công');
			}else{
				$this->loginFail('Change password: password incorrect');
				return array('result'=>false, 'message'=>'Mật khẩu không đúng');
			}
		}else{
			$this->loginFail('Change password: password empty');
			return array('result'=>false, 'message'=>'ERROR: Password.');
		}
	}
	
	private function createUsernamePassword($user, $password_new){
		if(isset($this->document['username']) && strlen($this->document['username'])>=6){
			$username = $this->model->_checkUser($this->document['username'], 6);
			if($username==false){
				$this->loginFail('Create username password: username incorrect');
				return array('result'=>false, 'message'=>'Tài khoản không có tự đặc biệt và hơn 6 ký tự.');
			}
			
			$filter = array(
				'where' => array('username'=>$username),
				'pretty' => array('_id'=>1),
			);
			$data = $this->model->findOne('users', $filter);
			if($data){
				$this->loginFail('Create username password: username existing');
				return array('result'=>false, 'message'=>'Tài khoản đã tồn tại, vui lòng chọn tên khác.');
			}
			
			$salt = $this->model->_randomString(5);
			$password = $this->model->_password( $password_new.$salt );
			
			$document = array(
				'username' => $username,
				'password' => $password,
				'salt' => $salt,
			);
			
			$filter = array(
				'_id' => $user['_id'],
			);
			
			$data = $this->model->update('users', $document, $filter);
			if($data){
				if(isset($_SESSION['users'])){
					$_SESSION['users']['username'] = $username;
				}else if(isset($_SESSION['admin'])){
					$_SESSION['admin']['username'] = $username;
				}
				return array('result'=>true, 'message'=>'Tạo tài khoản và mật khẩu thành công');
			}
		}else{
			$this->loginFail('Create username password: username empty');
			return array('result'=>false, 'message'=>'ERROR: Username.');
		}
	}
	
	private function changeInfo(){
		$user = $this->model->_getUser();
		if($user==''){
			return array('result'=>false, 'message'=>'ERROR: Vui lòng đăng nhập');
		}
		
		$document = array();
		
		$array = array('name', 'gender', 'birthday', 'address', 'tel');
		foreach($array as $name){
			if(isset($this->document[$name])){
				$document[$name] = $this->document[$name];
			}
		}
		
		$documentNew = $this->model->documentCheckAdmin('users', $document);
		$filter = array(
			'_id'=>$user['_id'],
		);
		$this->model->update('users', $documentNew, $filter);
		return array('result'=>true, 'message'=>'Thay đổi thành công');
	}
	
	private function loginFail($name){
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$document = array(
			'name' => $name,
			'type' => 'login',
			'ip_address' => $ip_address,
		);
		$this->model->create('users_logs', $document);
	}
}