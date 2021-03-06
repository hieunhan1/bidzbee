<?php
class modelDB{
	
	public function _id($id=NULL){
		try{
			$id = new MongoID($id);
		}catch(Exception $e){
			$id = new MongoID();
		}
		return $id;
	}
	
	public function _regex($str){
		try{
			return new MongoRegex($str);
		}catch(Exception $e){
			return false;
		}
	}
	
	public function _date($date='', $formatExport=_DATETIME_DEFAULT_, $formatCurrent=_DATETIME_){
		if(is_numeric($date)){
			$date = date($formatExport, $date);
			return $date;
		}
		if($date==''){
			$date = date($formatCurrent);
		}
        if(!preg_match('/:/i', $date)){
            $date .= ' 00:00:00';
        }
		$date = DateTime::createFromFormat($formatCurrent, $date);
		$date = $date->format($formatExport);
		return $date;
	}
	
	public function _dateMongo($dateObject='', $format=_DATETIME_){
		if($dateObject==''){
			$dateObject = new MongoDate(time());
		}
		$date = date($format, $dateObject->sec );
		return $date;
	}
	
	public function _dateObject($date=''){
		if($date==''){
			$date = time();
		}else{
			$date = $this->_date($date);
			$date = strtotime($date);
		}
		
		$dateObject = new MongoDate($date);
		return $dateObject;
	}
	
	public function _number($number){
		settype($number, 'int');
		return number_format($number, 0, ',', '.');
	}
	
	public function _print($arr){
		$str = '<pre>';
        ob_start();
		print_r($arr);
        $str .= ob_get_clean();
		$str .= '</pre>';
        return $str;
	}
    
    public function _error($message='Error'){
        $arr = array(
            'result' => false,
            'message' => $message,
        );
        return $arr;
    }
	
	public function _removeSymbol($str, $remove=true){
		if($remove==false) return $str;
		$str = str_replace('"', '', $str);
		$str = str_replace("'", '&#39;', $str);
		$str = str_replace('&', '', $str);
		$str = str_replace('<', '', $str);
		$str = str_replace('>', '', $str);
		return $str;
	}
	
	public function _removeScript($str, $remove=true){
		if($remove==false) return $str;
		$str = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $str);
		return $str;
	}
	
	public function _changeSymbol($str, $remove=true){
		if($remove==false) return $str;
		$str = str_replace("'", '&#39;', $str);
		$str = str_replace('\\', '&#92;', $str);
		$str = str_replace('"', '&quot;', $str);
		$str = str_replace('<', '&lt;', $str);
		$str = str_replace('>', '&gt;', $str);
		$str = trim($str);
		return $str;
	}
	
	public function _password($pass){
		$pass = crypt($pass, '258');
		return $pass;
	}
	
	public function _randomString($lenght){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
		$randstring = '';
		for($i=0; $i<$lenght; $i++) {
			$randstring .= $characters[rand(0, strlen($characters)-1)];
		}
		return $randstring;
	}
	
	public function _replace($search, $replace, $object, &$count=0){
		if(is_array($search)){
			foreach($search as $row){
				$object = str_replace('{'.$row.'}', $data[$row], $object, $count);
			}
		}else{
			$object = str_replace('{'.$search.'}', $replace, $object, $count);
		}
		
		return $object;
	}
	
	public function _setValue($value){
		if(!preg_match('/^var /i', $value) && !preg_match('/^function /i', $value)){
			if(is_numeric($value)){
				if(!preg_match('/\./', $value)){
					settype($value, 'int');
				}else{
					settype($value, 'float');
				}
			}else if($value=='true'){
				$value = true;
			}else if($value=='false'){
				$value = false;
			}
		}else{
			if(preg_match('/^var /i', $value)){
				$str = preg_replace('/^var /i', '', $value);
				$str = '$value = '.$str.';';
			}else if(preg_match('/^function /i', $value)){
				$str = preg_replace('/^function /i', '', $value);
			}
			
			eval($str);
		}
		
		return $value;
	}
	
	public function _getWhere($keys, $value){
		$listCompare = array('$ne', '$gt', '$gte', '$lt', '$lte'); //'$in', '$regex', '$date', '$or'
		$where = '';
		
		$keys = trim($keys);
		$key = str_replace('  ', ' ', $keys);
		$key = str_replace('  ', ' ', $key);
		$key = explode(' ', $key);
		$total = count($key);
		
		if(!is_bool($value) && gettype($value)!='object'){
			$value = trim($value);
		}
		
		if($total==1){
			$where = $this->_setValue($value);
		}else if($total==2){
			$name = $key[0];
			$compare = $key[1];
			if(in_array($compare, $listCompare)){
				$where = array($compare => $this->_setValue($value));
			}else if($compare=='$in'){
				$value = str_replace(' ,', ',', $value);
				$value = str_replace(', ', ',', $value);
				
				$values = explode(',', $value);
				$value = array();
				foreach($values as $k=>$v){
					$value[$k] = $this->_setValue($v);
				}
				$where = array($compare => $value);
			}else if($compare=='$regex'){
				$where = $this->_regex($value);
			}else if($compare=='$date'){
				$where = $this->_dateObject($value);
			}
		}else{
			if($key[0]=='or'){
				$where = array();
				$key = explode(' | ', $keys);
				$value = explode(' | ', $value);
				for($i=1; $i<count($key); $i++){
					$k = $key[$i];
					$k = str_replace('  ', ' ', $k);
					$k = str_replace('  ', ' ', $k);
					$k = explode(' ', $k);
					$v = $value[$i-1];
					
					$where[] = array($k[0] => $this->_getWhere($key[$i], $v));
				}
			}else if($key[1]=='$date'){
				$where = array();
					
				$value = str_replace(' ,', ',', $value);
				$value = str_replace(', ', ',', $value);
				$value = explode(',', $value);
				
				for($i=2; $i<$total; $i++){
					$k = $key[$i];
					$v = '';
					if(isset($value[$i-2])){
						$v = $value[$i-2];
						$v = $this->_dateObject($v);
					}
					$where[$k] = $v;
				}
			}else{
				$where = array();
					
				$value = str_replace(' ,', ',', $value);
				$value = str_replace(', ', ',', $value);
				$value = explode(',', $value);
				
				for($i=1; $i<$total; $i++){
					$k = $key[$i];
					$v = '';
					if(isset($value[$i-1])) $v = $value[$i-1];
					$where[$k] = $this->_setValue($v);
				}
			}
		}
		
		return $where;
	}
	
	public function _getCollectionFilter($data){
		$where = array();
		$pretty = array();
		$sort = array();
		$limit = _LIMIT_;
		$skip = 0;
		
		if(isset($data['pretty']) && is_array($data['pretty'])){
			foreach($data['pretty'] as $row){
				$pretty[$row] = 1;
			}
		}
		
		if(isset($data['where']) && is_array($data['where'])){
			$where = array();
			foreach($data['where'] as $keys=>$value){
				$key = explode(' ', $keys);
				$name = $key[0];
				if($name=='or') $name = '$or';
				$where[$name] = $this->_getWhere($keys, $value);
			}
		}
		
		if(isset($data['search']) && is_array($data['search'])){
			$search = $data['search'];
			foreach($_GET as $name=>$value){
				if(isset($search[$name]) && $value!='null' && $value!=''){
					$keys = $name;
					if(isset($search[$name]['condition']) && $search[$name]['condition']!='0'){
						if($search[$name]['condition']=='$regex'){
							$value = "/{$value}/i";
						}
						$keys = $name.' '.$search[$name]['condition'];
					}
					
					if($name=='or') $name = '$or';
					
					if(isset($search[$name]['check'])){
						$check = '_check'.ucfirst($search[$name]['check']);
						$value = $this->$check($value, NULL);
					}
					
					$where[$name] = $this->_getWhere($keys, $value);
				}
			}
		}
		
		if(isset($data['sort'])){
			$sort = $data['sort'];
		}
		
		if(isset($data['limit']) && $data['limit']>0){
			$limit = $data['limit'];
		}
		
		if(!isset($_GET['number'])){
			$page = 1;
		}else{
			$page = $_GET['number'];
			settype($page, 'int');
			if($page <= 0){
				$page = 1;
			}
		}
		$skip = ($page - 1) * $limit;
		
		$filter = array(
			'where' => $where,
			'pretty' => $pretty,
			'sort' => $sort,
			'limit' => $limit,
			'skip' => $skip,
		);
		
		return $filter;
	}
	
	public function _getUser(){
		if(isset($_SESSION['users']) && isset($_SESSION['admin'])){
			if(!isset($_SESSION['admin']['groups'])){
				unset($_SESSION['admin']);
				return false;
			}
			$user = $_SESSION['admin'];
		}else if(isset($_SESSION['users'])){
			if(!isset($_SESSION['users']['groups'])){
				$_SESSION['users']['groups'] = 'users';
			}
			$user = $_SESSION['users'];
		}else if(isset($_SESSION['admin'])){
			if(!isset($_SESSION['admin']['groups'])){
				unset($_SESSION['admin']);
				return false;
			}
			$user = $_SESSION['admin'];
		}else{
			$user = '';
		}
		
		return $user;
	}
	
	public function _authorityCheck($user, $authority){
		$allow = array(
			'read' => 0,
			'create' => 0,
			'update' => 0,
			'delete' => 0,
		);
		
		//kiem tra quyen user
		if(isset($user['username'])){
			$username = $user['username'];
			if(isset($authority['users'])){
				$users = $authority['users'];
				if(isset($users[$username])){
					$allow = $users[$username];
					return $allow;
				}
			}
		}
		
		//kiem tra group
		if(isset($authority['groups']) && isset($user['groups'])){
			$group = $authority['groups'];
			$groupUser = $user['groups'];
			
			if(!is_array($groupUser)){ //user ở 1 group
				if(isset($group[$groupUser])){
					$allow = $group[$groupUser];
				}
			}else{ //user ở nhiều group
				foreach($groupUser as $row){
					//kiem tra groupUser có tồn tại trong Group
					if(isset($group[$row])){
						//Get quyền
						foreach($group[$row] as $key=>$a){
							if($a==1){
								$allow[$key] = 1;
							}
						}
					}
				}
			}
		}
		
		return $allow;
	}
	
	public function _authorityCollection($user, $auth){
		$fieldAuth = array();
		foreach($fields as $key=>$field){
			if(isset($field['authority'])){
				$fieldAuth[$key] = $field['authority'];
			}
		}
		
		$userAuth = array();
		if(count($fieldAuth) > 0){
			foreach($fieldAuth as $key=>$auth){
				$userAuth[$key] = $this->_authorityCheck($user, $auth);
			}
		}
		
		return $userAuth;
	}
	
	public function _authorityFields($user, $fields){
		$fieldAuth = array();
		foreach($fields as $key=>$field){
			if(isset($field['authority'])){
				$fieldAuth[$key] = $field['authority'];
			}
		}
		
		$userAuth = array();
		if(count($fieldAuth) > 0){
			foreach($fieldAuth as $key=>$auth){
				$userAuth[$key] = $this->_authorityCheck($user, $auth);
			}
		}
		
		return $userAuth;
	}
	
	public function _documentCheck($fields, $document, &$error){
		$error = array();
		$documentNew = array();
		if(isset($document['_id'])){
			$documentNew['_id'] = $document['_id'];
		}
		
		foreach($fields as $key=>$field){
			$check = '_check'.ucfirst($field['check']);
			$condition = 0;
			if(isset($field['condition'])){
				$condition = $field['condition'];
			}
			
			$data = '';
			if(isset($document[$key])){
				$data = $document[$key];
			}
			
			//kiem tra tồn tai function
			if( method_exists(get_class(), $check) ){
				$result = $this->$check($data, $condition);
			}else{
				$error = array('result'=>false, 'message'=>'Does not exist check '.strtoupper($field['check']));
				return false;
			}
			
			//xuất lỗi nếu có
			if(is_bool($result) && $result==false){
				$error[$key] = $data;
			}else{
				$documentNew[$key] = $result;
			}
		}
		
		if(count($error)==0){
			return $documentNew;
		}else{
			return false;
		}
	}
	
	public function _checkString($data, $condition){
		if(!is_array($data)){
			$data = $this->_changeSymbol($data);
		}else{
			return $data;
		}
		
		settype($condition, 'int');
		if($data=='' && $condition==0){
			return $data;
		}
		
		if(strlen($data) >= $condition){
			return $data;
		}else{
			return false;
		}
	}
	
	public function _checkNumber($data, $condition){
		$data = trim($data);
		settype($condition, 'int');
		if($data=='' && $condition==0){
			return $data;
		}
		
		if(strlen($data)>=$condition){
			if(!preg_match('/\./', $data)){
				settype($data, 'int');
			}else{
				settype($data, 'float');
			}
			
			return $data;
		}else{
			return false;
		}
	}
	
	public function _checkTel($data, $condition){
		$data = trim($data);
		settype($condition, 'int');
		if($data=='' && $condition==0){
			return $data;
		}
		
		$pattern = '/^[{0,(,+}][0-9-+()\.\s]{9,18}$/';
		if(preg_match($pattern, $data)){
			return $data;
		}else{
			return false;
		}
	}
	
	public function _checkEmail($data, $condition=NULL){
		$data = trim($data);
		settype($condition, 'int');
		if($data=='' && $condition==0){
			return $data;
		}
		
		$pattern = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$/';
		if(preg_match($pattern, $data)){
			return $data;
		}else{
			return false;
		}
	}
	
	public function _checkTextCKeditor($data, $condition){
		$data = $this->_removeScript($data);
		
		settype($condition, 'int');
		if($data=='' && $condition==0){
			return $data;
		}
		
		if(strlen($data) >= $condition){
			return $data;
		}else{
			return false;
		}
	}
	
	public function _validateDate($date, $format){
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
	
	public function _checkDate($data, $condition){
		$data = trim($data);
		settype($condition, 'int');
		if($data=='' && $condition==0){
			return $data;
		}
		
		if($this->_validateDate($data, _DATETIME_)==true){
			$data = $this->_dateObject($data);
		}else if($this->_validateDate($data, _DATE_)==true){
			$data = $this->_dateObject($data);
		}else{
			return false;
		}
		
		return $data;
	}
	
	public function _checkUser($data, $condition=NULL){
		$data = trim($data);
		settype($condition, 'int');
		if($data=='' && $condition==0){
			return $data;
		}
		
		$pattern = '/^\w+([\.]?\w+){2,30}$/';
		if(preg_match($pattern, $data) && strlen($data)>=$condition){
			return $data;
		}else{
			return false;
		}
	}
	
	public function _checkBool($data, $condition){
		$data = trim($data);
		settype($condition, 'int');
		if($data=='' && $condition==0){
			return $data;
		}
		
		if($data==1 || $data=='true'){
			$data = true;
		}else{
			$data = false;
		}
		
		return $data;
	}
	
	public function _checkConfirm($data, $condition){
		return $data;
	}
	
	public function _removeDataEmpty($arr){
		$arrNew = array();
		if(is_array($arr)){
			foreach($arr as $key=>$row){
				if(is_array($row)){
					$row = $this->_removeDataEmpty($row);
					if(count($row)>0){
						$arrNew[$key] = $row;
					}
				}else if($row!='' || $row=='0' || is_bool($row)){
					$arrNew[$key] = $row;
				}
			}
		}else if($arr!=''){
			return $arr;
		}
		
		return $arrNew;
	}
    
    public function _connectDatabase($arr=NULL){
		try{
			if($arr===NULL){
				$host = _HOST_;
				$data = _DB_;
				$user = _DB_USER_;
				$pass = _DB_PASS_;
			}else{
				$host = $arr['host'];
				$data = $arr['data'];
				$user = $arr['user'];
				$pass = $arr['pass'];
			}
            
            $mongo = new MongoClient("mongodb://".$host, array("username"=>$user, "password"=>$pass));
			return $mongo->selectDB($data);
		}catch(MongoConnectionException $e){
			echo '<p>Couldn\'t connect to mongodb, is the "mongo" process running?</p>';
			exit();
		}
	}
	
	public function _select($db, $collection){
		return $db->selectCollection($collection);
	}
	
	public function _insert($collection, $document){
		$document = $this->_removeDataEmpty($document);
		
		if(!isset($document['_id'])){
			$document['_id'] = $this->_id();
		}else{
			$document['_id'] = $this->_id($document['_id']);
		}
		
		$document['_create'] = array(
			'datetime' => $this->_dateObject(),
		);
		
		$user = $this->_getUser();
		if($user != ''){
			$userNew = array(
				'_id' => (string)$user['_id'],
				'name' => (string)$user['name'],
			);
			if(isset($user['username'])){
				$userNew['username'] = $user['username'];
			}
		}
		if(isset($userNew)){
			$document['_create']['user'] = $userNew;
		}
		
		$result = $collection->insert($document);
		if($result['ok']==1){
			foreach($document['_id'] as $_id){
				return array('_id'=>$_id);
			}
		}else{
			return false;
		}
	}
	
	public function _save($collection, $document){
		$document = $this->_removeDataEmpty($document);
		
		if(isset($document['_id'])){
			$document['_id'] = $this->_id($document['_id']);
		}else{
			$document['_id'] = $this->_id();
		}
		
		$document['_create'] = array(
			'datetime' => $this->_dateObject(),
		);
		
		$user = $this->_getUser();
		if($user != ''){
			$userNew = array(
				'_id' => (string)$user['_id'],
				'name' => (string)$user['name'],
			);
			if(isset($user['username'])){
				$userNew['username'] = $user['username'];
			}
		}
		if(isset($userNew)){
			$document['_create']['user'] = $userNew;
		}
		
		$result = $collection->save($document);
		if($result['ok']==1){
			foreach($document['_id'] as $_id){
				return array('_id'=>$_id);
			}
		}else{
			return false;
		}
	}
	
	public function _remove($collection, $document){
		if(isset($document['_id'])){
			$document['_id'] = $this->_id($document['_id']);
		}
		
		$result = $collection->remove($document);
		if($result['ok']==1){
			return $result;
		}else{
			return false;
		}
	}
	
	public function _update($collection, $document, $filter){
		//$set: SET age = 3
		//$inc: SET age = age + 3
		if(isset($document['_removeDataEmpty'])){
			$document = $this->_removeDataEmpty($document);
			unset($document['_removeDataEmpty']);
		}
		
		if(count($document)==0){
			return false;
		}
		
		if(!isset($filter[_MULTI_])){
			$multi = array('multi'=>false);
		}else{
			$multi = $filter[_MULTI_];
			unset($filter[_MULTI_]);
			
			settype($multi, 'int');
			if($multi!=1){
				$multi = false;
			}
			$multi = array('multi'=>$multi);
		}
		
		if(!isset($filter[_SET_])){
			$set = '$set';
		}else{
			$set = $filter[_SET_];
			unset($filter[_SET_]);
			
			if($set!='$set' && $set!='$inc'){
				$set = '$set';
			}
		}
		
		if(isset($filter['_id'])){
			$filter['_id'] = $this->_id($filter['_id']);
		}
		
		$document['_update'] = array(
			'datetime' => $this->_dateObject(),
		);
		
		$user = $this->_getUser();
		if($user != ''){
			$userNew = array(
				'_id' => (string)$user['_id'],
				'name' => (string)$user['name'],
			);
			if(isset($user['username'])){
				$userNew['username'] = $user['username'];
			}
		}
		if(isset($userNew)){
			$document['_update']['user'] = $userNew;
		}
		
		$result = $collection->update($filter, array($set=>$document), $multi);
		if($result){
			return $result;
		}else{
			return false;
		}
	}
	
	public function _findAndModify($collection, $query, $update, $fields=NULL, $options=NULL){
		$data = $collection->findAndModify($query, $update, $fields, $options);
		return $data;
	}
	
	public function _find($collection, $filter){
		$where = array();
		$pretty = array();
		$sort = array();
		$limit = '';
		$skip = '';
		
		if(isset($filter['where']) && is_array($filter['where'])){
			$where = $filter['where'];
			if(isset($where['_id'])){
				$where['_id'] = $this->_id($where['_id']);
			}
		}
		
		if(isset($filter['pretty'])){
			foreach($filter['pretty'] as $key=>$value){
				settype($value, 'int');
				if($value!=1){
					$value = false;
				}
				$pretty[$key] = $value;
			}
		}
		
		if(isset($filter['sort'])){
			foreach($filter['sort'] as $key=>$value){
				settype($value, 'int');
				if($value != 1){
					$value = -1;
				}
				$sort[$key] = $value;
			}
		}
		
		if(!isset($filter['limit'])){
			$find = $collection->find($where, $pretty)->sort($sort);
		}else{
			$limit = $filter['limit'];
			settype($limit, 'int');
			
			if(!isset($filter['skip'])){
				$find = $collection->find($where, $pretty)->sort($sort)->limit($limit);
			}else{
				$skip = $filter['skip'];
				settype($skip, 'int');
				$find = $collection->find($where, $pretty)->sort($sort)->limit($limit)->skip($skip);
			}
		}
		
		try{
			return iterator_to_array($find); //convert Object to Array
		}catch(MongoCursorException $e){
			return false;
		}
	}
	
	public function _findOne($collection, $filter){
		$where = array();
		$pretty = array();
		if(isset($filter['where'])){
			$where = $filter['where'];
		}
		if(isset($where['_id'])){
			$where['_id'] = $this->_id($where['_id']);
		}
		
		if(isset($filter['pretty'])){
			foreach($filter['pretty'] as $key=>$value){
				settype($value, 'int');
				$pretty[$key] = $value;
			}
		}
		
		$result = $collection->findOne($where, $pretty);
		if(count($result)==1){
			return end($result);
		}
		
		return $result;
	}
	
	public function _count($collection, $where){
		$pretty = array('_id'=>1);
		$result = $collection->find($where, $pretty)->count();
		return $result;
	}
	
	public function _getIndexInfo($collection){
		$data = $collection->getIndexInfo(); //db.pages.getIndexes();
		return $data;
	}
	
	public function _createIndex($collection, $arr){ 
		$data = $collection->createIndex($arr, array('unique'=>1, 'dropDups'=>1));
		return $data;
	}
	
	public function _deleteIndex($collection, $arr){
		$data = $collection->deleteIndex($arr);
		return $data;
	}
	
	public function _ensureIndex($collection, $arr){
		$data = $collection->ensureIndex($arr, array('unique'=>1, 'dropDups'=>1));
		return $data;
	}
	
	public function _aggregate($collection, $arrOption){
		$data = $collection->aggregate($arrOption);
		return $data;
	}
	
	public function _explain($collection, $arrWhere=array()){
		//COLLSCAN for a collection scan
		//IXSCAN for scanning index keys
		//FETCH for retrieving documents
		//SHARD_MERGE for merging results from shards
		$data = $collection->find($arrWhere)->explain();
		return $data;
	}
}