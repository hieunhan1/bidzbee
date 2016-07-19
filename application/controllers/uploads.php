<?php
class uploads{
	private $model;
	
	public function upload($model){
		$this->model = $model;
		
		$result = array();
		foreach($_FILES['files']['name'] as $position=>$name){
			$type = $_FILES['files']['type'][$position];
			$size = $_FILES['files']['size'][$position];
			$temp = $_FILES['files']['tmp_name'][$position];
			
			if($size < _UPLOAD_SIZE_){
				$checkExtension = $this->checkExtension($name);
				if( $checkExtension!=false ){
					$newname = $this->model->_id();
					$newname = (string)$newname;
					$filenew = $newname . '.' . $checkExtension['ext'];
					
					if(move_uploaded_file($temp, _UPLOAD_TEMP_.$filenew)){
						$data = $this->viewImageTemp($newname, $checkExtension['name'], $filenew);
						$result[] = array('name'=>$newname, 'data'=>$data);
					}else{
						$result[] = array('name'=>$name, 'message'=>'ERROR: Moving!');
					}
				}else{
					$result[] = array('name'=>$name, 'message'=>'TYPE: Không hỗ trợ file này');
				}
			}else{
				$result[] = array('name'=>$name, 'message'=>'SIZE: '.$size);
			}
		}
		
		return $result;
	}
	
	public function uploadAction($model, $document){
		$this->model = $model;
		if(isset($document['files'])){
			$document = $document['files'];
			
			$filter = array(
				'where' => array('id'=>$document['id']),
			);
			$dataFiles = $this->model->findOne(_FILES_, $filter);
			
			//create collection files
			if(count($dataFiles) == 0){
				$result = array();
				foreach($document['data'] as $row){
					$name = $row['name'];
					$file = $row['file'];
					$filetemp = _UPLOAD_TEMP_ . $file;
					if(file_exists($filetemp)){
						$result[] = $this->fileProcess($file, $name);
					}else{
						$result[] = array('result'=>false, 'message'=>'', 'data'=>$row);
					}
				}
				
				if(count($result) > 0){
					if(isset($document['data'])){
						$document['data'] = $result;
					}
					
					$this->model->create(_FILES_, $document);
				}
			}else{ //update collection files
				$result = array();
				foreach($document['data'] as $row){
					$name = $row['name'];
					$file = $row['file'];
					$filetemp = _UPLOAD_TEMP_ . $file;
					if(file_exists($filetemp)){
						$result[] = $this->fileProcess($file, $name);
					}
				}
				
				if(count($result) > 0){
					if(isset($dataFiles['data'])){
						$document['data'] = $dataFiles['data'];
					}
					
					foreach($result as $row){
						array_push($document['data'], $row);
					}
					
					$filter = array();
					$filter['_id'] = $dataFiles['_id'];
					$this->model->update(_FILES_, $document, $filter);
				}
			}
				
			return $result;
		}else{
			return false;
		}
	}
	
	private function checkExtension($filename){
		$array = array(
			'jpeg', 'jpg', 'gif', 'png', 'bmp',
			'wma', 'mp3',
			'txt', 'xls', 'xlsx', 'doc', 'docx', 'xml', 'cvs', 'pdf', 'zip',
			'mp4', 'wmv', 'avi', 'flv',
		);
		
		$filename = explode('.', $filename);
		$name = $this->model->_removeSymbol($filename[0]);
		$extension = strtolower( end($filename) );
		
		if(in_array($extension, $array)){
			return array(
				'name' => $name,
				'ext'  => $extension,
			);
		}else{
			return false;
		}
	}
	
	private function viewImageTemp($newname, $name, $file){
		$str = '';
		
		$check = $this->checkTypeUpload($file, $name);
		if(isset($check['type'])){
			$name = $check['name'];
			$id   = $check['file'];
			$file = $check['file'] . '.' . $check['extension'];
			$url = _URL_TEMP_ . $file;
			
			if($check['type']=='image'){
				$str = '<div class="item" id="'.$id.'" _name="'.$name.'" _file="'.$file.'" _url="'.$url.'">
					<p class="avarta">chọn làm<br />ảnh đại diện</p>
					<p class="img imgWidth"><img src="'.$url.'" alt="'.$name.'" /></p>
					<p class="insert"><a href="javascript:;">Insert</a></p>
					<p class="delete"><a href="javascript:;">Delete</a></p>
				</div>';
			}else{
				$str = '<div class="item" id="'.$id.'" _name="'.$name.'" _file="'.$file.'" _url="'.$url.'">
					<p class="avarta">chọn làm<br /> đại diện</p>
					<p class="img imgWidth"><span>'.$check['extension'].'</span></p>
					<p class="copy"><a href="javascript:;">Copy link</a></p>
					<p class="delete"><a href="javascript:;">Delete</a></p>
				</div>';
			}
		}
		
		return $str;
	}
	
	private function checkTypeUpload($file, $name=''){
		$image = array('jpeg', 'jpg', 'gif', 'png', 'bmp');
		$audio = array('wma', 'mp3');
		$files = array('txt', 'xls', 'xlsx', 'doc', 'docx', 'xml', 'cvs', 'pdf', 'zip');
		$video = array('mp4', 'wmv', 'avi', 'flv');
		
		$arr = explode('.', $file);
		$file = $arr[0];
		$extension = end($arr);
		
		$type = '';
		if( in_array($extension, $image) ){
			$type = 'image';
		}
		
		if( in_array($extension, $audio) ){
			$type = 'audio';
		}
		
		if( in_array($extension, $files) ){
			$type = 'files';
		}
		
		if( in_array($extension, $video) ){
			$type = 'video';
		}
		
		if($type != ''){
			return array('type'=>$type, 'name'=>$name, 'file'=>$file, 'extension'=>$extension);
		}else{
			return false;
		}
	}
	
	private function imageProcess($fileInfo){
		$file = $fileInfo['file'] . '.' . $fileInfo['extension'];
		$filetemp = _UPLOAD_TEMP_ . $file;
		$sizeInfo = getimagesize($filetemp);
		if(is_array($sizeInfo)){
			include_once('libraries/SimpleImage.php');
			$image = new SimpleImage();
			
			$image->load($filetemp);
			$width = $sizeInfo[0];
			$height = $sizeInfo[1];
			
			//img thumb
			$imageThumb = _UPLOAD_THUMB_ . $file;
			if($width<=_THUMB_WIDTH_ && $height<=_THUMB_HEIGHT_){
				copy($filetemp, $imageThumb);
			}else if($width >= $height){
				$image->resizeToWidth(_THUMB_WIDTH_);
				$image->save($imageThumb);
			}else if($width < $height){
				$image->resizeToHeight(_THUMB_HEIGHT_);
				$image->save($imageThumb);
			}
			
			//img
			$img = _UPLOAD_IMAGE_ . $file;
			if(copy($filetemp, $img)){
				unlink($filetemp);
			}else{
				return array('result'=>false, 'message'=>'ERROR: copy file');
			}
			
			return $fileInfo;
		}else{
			return array('result'=>false, 'message'=>'ERROR: file image');
		}
	}
	
	private function audioProcess($file){
		
	}
	
	private function filesProcess($file){
		
	}
	
	private function videoProcess($file){
		
	}
	
	private function fileProcess($file, $name){
		$check = $this->checkTypeUpload($file, $name);
		if(isset($check['type'])){
			if($check['type'] == 'image'){
				return $this->imageProcess($check);
			}
			
			if($check['type'] == 'audio'){
				return $this->audioProcess($check);
			}
			
			if($check['type'] == 'files'){
				return $this->filesProcess($check);
			}
			
			if($check['type'] == 'video'){
				return $this->videoProcess($check);
			}
		}
		
		return false;
	}
}