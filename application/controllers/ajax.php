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
	
	//kiem tra thong tin
	private function getInfo(){
		if( !isset($this->document['where']) || !isset($this->document['collection']) ){
			return array('result'=>false, 'message'=>'ERROR: Dữ liệu không đủ');
		}
		
		$collection = $this->document['collection'];
		$filter = array(
			'where' => $this->document['where'],
		);
		if(isset($this->document['pretty'])){
			$filter['pretty'] = $this->document['pretty'];
		}
		
		$data = $this->model->findOne($collection, $filter);
		if($data){
			if(isset($data['_id'])){
				$data['_id'] = (string)$data['_id'];
			}
			return array('result'=>true, 'data'=>$data);
		}else{
			return array('result'=>true, 'message'=>'Không tìm thấy dữ liệu yêu cầu');
		}
	}
	//end kiem tra thong tin
	
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
	
	private function deleteFiles(){
		if(!isset($this->document['id']) || !isset($this->document['file'])){
			return array('result'=>false, 'message'=>'ERROR: Dữ liệu không đủ');
		}
		
		$user = $this->model->_getUser();
		if($user!=''){
			if((is_array($user['groups']) && in_array('administrators', $user['groups'])) || $user['groups']=='administrators'){
				$filter = array(
					'where' => array(
						'id'=>$this->document['id'],
						'data.file'=>$this->document['file'],
						//'_create.user._id'=>(string)$user['_id'],
					),
				);
			}else{
				$filter = array(
					'where' => array(
						'id'=>$this->document['id'],
						'data.file'=>$this->document['file'],
						'_create.user._id'=>(string)$user['_id'],
					),
				);
			}
			$data = $this->model->findOne(_FILES_, $filter);
			if($data){
				$listFile = $data['data'];
				foreach($listFile as $key=>$row){
					if($row['file']==$this->document['file']){
						array_splice($listFile, $key, 1);
						
						$file = $row['file'].'.'.$row['extension'];
						
						if($row['type']=='image'){
							$url = _UPLOAD_IMAGE_;
							if(file_exists(_UPLOAD_THUMB_ . $file)){
								unlink(_UPLOAD_THUMB_ . $file);
							}
						}else if($row['type']=='files'){
							$url = _UPLOAD_FILES_;
						}else if($row['type']=='audio'){
							$url = _UPLOAD_AUDIO_;
						}else if($row['type']=='video'){
							$url = _UPLOAD_VIDEO_;
						}
						
						if(file_exists($url . $file)){
							unlink($url . $file);
						}
					}
				}
				
				$document = array();
				$document['data'] = $listFile;
				$filter = array(
					'id' => $this->document['id'],
				);
				$this->model->update(_FILES_, $document, $filter);
				
				return array('result'=>true, 'message'=>'Success!');
			}else{
				$file = '';
				if(isset($this->document['fileFull'])){
					$file = $this->document['fileFull'];
				}
				if(file_exists(_UPLOAD_TEMP_ . $file)){
					unlink(_UPLOAD_TEMP_ . $file);
					return array('result'=>true, 'message'=>'Success! Temp!');
				}else{
					return array('result'=>false, 'message'=>'ERROR: Không tìm thấy dữ liệu');
				}
			}
		}else{
			return array('result'=>false, 'message'=>'ERROR: Bạn không có quyền');
		}
	}
	//END ACTION UPLOAD
	
	//BID
	private function BID(){
		include_once('bid.php');
		$bid = new bid();
		$result = $bid->handle($this->model, $this->document);
		return $result;
	}
	
	private function viewDetail(){
		if(!isset($this->document['_id']) || !isset($this->document['collection'])){
			return array('result'=>false, 'message'=>'ERROR: Dữ liệu không đủ');
		}
		
		$_id = $this->document['_id'];
		$collection = $this->document['collection'];
		
		$filter = array(
			'where' => array('_id'=>$_id),
		);
		$data = $this->model->findOne($collection, $filter);
		
		//reminders
		$count = 0;
		$btnReminders = 'view-frm-register';
		$user = $this->model->_getUser();
		if(isset($data['reminders'])){
			$count = count($data['reminders']);
			if($user!=''){
				$btnReminders = 'btnReminders';
				foreach($data['reminders'] as $row){
					if($row['_id']==(string)$user['_id']){
						$btnReminders = 'active';
					}
				}
			}
		}else{
			if($user!=''){
				$btnReminders = 'btnReminders';
			}
		}
		$reminders = '<span class="reminders '.$btnReminders.'" type="register" _id="'.$data['_id'].'"></span> <b>'.$count.'</b> nhắc nhở';
		
		//list image
		$strListImg = '';
		$filter = array(
			'where' => array('id'=>$_id),
		);
		$listImage = $this->model->findOne(_FILES_, $filter);
		if($listImage && isset($listImage['data']) && count($listImage['data'])>1){
			foreach($listImage['data'] as $row){
				$file = $row['file'].'.'.$row['extension'];
				if($file!=$data['img']){
					$active = '';
				}else{
					$active = ' active';
				}
				$strListImg .= '<p class="img imgWidth'.$active.'" url="'._URL_IMAGE_.$file.'"><img src="'._URL_THUMB_.$file.'" alt="'.$row['name'].'" /></p>';
			}
			
			$strListImg = '<div class="img-list">'.$strListImg.'<p class="clear1"></p></div>';
		}
		
		$strData = '<div id="bid-detail">
			<div class="img imgHeight"><img src="'._URL_IMAGE_.$data['img'].'" alt="'.$data['name'].'" /></div>
			'.$strListImg.'
			<div class="content viewpost">
				<h1 style="font-size: 135%">'.$data['name'].'</h1>
				<div class="more">
					<p>Giá thị trường: <b>'.$this->model->_number($data['price_cost']).' Đ</b></p>
					<p>Giá khởi điểm: <b>'.$this->model->_number($data['price_start']).' Đ</b></p>
					<p>Bước giá: <b>'.$this->model->_number($data['price_step']).' Đ</b></p>
					<p>Shipping: <b>'.$data['shipping'].'</b></p>
					<p>Ngày BID: <b style="color:#06F">'.date(_DATETIME_, $data['date_bid']->sec).'</b></p>
					<p>'.$reminders.'</p>
				</div>
				'.$data['content'].'
			</div>
			<p class="clear1"></p>
		</div>';
		
		if($data){
			return array('result'=>true, 'data'=>$strData);
		}else{
			return array('result'=>false, 'message'=>'ERROR: Không tìm thấy');
		}
	}
	
	private function reminders(){
		if(!isset($this->document['_id'])){
			return array('result'=>false, 'message'=>'ERROR: Dữ liệu không đủ');
		}
		
		$user = $this->model->_getUser();
		if($user==""){
			return array('result'=>false, 'message'=>'ERROR: Vui lòng đăng nhập');
		}
		
		$count = 0;
		$filter = array(
			'where' => array('_id'=>$this->document['_id']),
			'pretty' => array('_id'=>0, 'status'=>1, 'reminders'=>1),
		);
		$data = $this->model->findOne('posts', $filter);
		if($data){
			$dataNew = array(
				'_id' => (string)$user['_id'],
				'name' => $user['name'],
				'email' => $user['email'],
				'datetime' => $this->model->_dateObject(),
			);
			
			$document = array();
			
			if(isset($data['reminders'])){
				$count = count($data['reminders']);
				foreach($data['reminders'] as $row){
					if($row['_id']==(string)$user['_id']){
						return array('result'=>false, 'message'=>'ERROR: Bạn đã chọn nhắc nhở cho sản phẩm này rồi');
					}
				}
				
				$document['reminders'] = $data['reminders'];
				array_push($document['reminders'], $dataNew);
			}else{
				$document['reminders'][] = $dataNew;
			}
			
			$count = $count + 1;
		}else{
			return array('result'=>false, 'message'=>'ERROR: Không tìm thấy dữ liệu');;
		}
		
		$filter = array(
			'_id' => $this->document['_id'],
		);
		$this->model->update('posts', $document, $filter);
		
		return array('result'=>true, 'count'=>$count);
	}
	
	private function viewUserBID(){
		if(!isset($this->document['product'])){
			return array('result'=>false, 'message'=>'ERROR: Dữ liệu không đủ');
		}
		
		$filter = array(
			'where' => array('product'=>$this->document['product']),
			'sort' => array('_id'=>-1),
		);
		$data = $this->model->find('user_bid', $filter);
		if($data){
			$i = 0;
			$item = '';
			$item2 = '';
			foreach($data as $row){
				$i++;
				if($i<=3){
					$filter = array(
						'where' => array('_id'=>$row['user']['_id']),
						'pretty' => array('email'=>1, 'phone'=>1, 'address'=>1),
					);
					$user = $this->model->findOne('users', $filter);
					
					$tel = '';
					if(isset($user['tel'])){
						$tel = '<p class="tel">Điện thoại: '.$user['tel'].'</p>';
					}
					
					$address = '';
					if(isset($user['address'])){
						$address = '<p class="address">Địa chỉ: '.$user['address'].'</p>';
					}
					
					$item .= '<div class="item">
						<p class="price">Giá: '.$this->model->_number($row['price']).'đ</p>
						<p class="name">Người BID: '.ucfirst($row['user']['name']).'</p>
						<p class="date">Ngày BID: '.date(_DATETIME_, $row['date_bid']->sec).'</p>
						<p class="email">Email: '.$user['email'].'</p>
						'.$tel.$address.'
					</div>';
				}else{
					$item2 .= '<p class="item2">
						<span class="price">Giá: '.$this->model->_number($row['price']).'đ</span>
						<span class="name">'.ucfirst($row['user']['name']).'</span>
						<span class="date">('.date(_DATETIME_, $row['date_bid']->sec).')</span>
					</p>';
				}
			}
			
			$str = '<div class="frmUserBID">'.$item.'<p class="clear1"></p>'.$item2.'</div>';
			return array('result'=>true, 'data'=>$str);
		}else{
			return array('result'=>false, 'message'=>'ERROR: Không tìm thấy dữ liệu');;
		}
	}
	//end BID
}

$control = new ajax();