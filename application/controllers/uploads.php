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
				$type = $this->checkExtension($type);
				if( $type!=false ){
					$newname = $this->model->_id();
					$newname = (string)$newname . '.' . $type;
					
					if(move_uploaded_file($temp, _UPLOAD_TEMP_.$newname)){
						$data = $this->viewImageTemp($newname);
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
	
	private function checkExtension($type){
		/*$arr = array(
			'image/jpeg' => array('jpg', '../public/images/', '../public/thumbs/'),
			'image/gif' =>  array('gif', '../public/images/', '../public/thumbs/'),
			'image/png' =>  array('png', '../public/images/', '../public/thumbs/'),
			'image/bmp' =>  array('bmp', '../public/images/', '../public/thumbs/'),
		);*/
		$arr = array(
			'image/jpeg' => 'jpg',
			'image/gif' =>  'gif',
			'image/png' =>  'png',
			'image/bmp' =>  'bmp',
		);
		
		if(isset($arr[$type])){
			return $arr[$type];
		}else{
			return false;
		}
	}
	
	private function viewImageTemp($image){
		$str = '<div class="item" _image="'.$image.'" _url="'._URL_TEMP_.$image.'">
        	<p class="avarta">chọn làm<br />ảnh đại diện</p>
            <p class="img imgWidth"><img src="'._URL_TEMP_.$image.'" alt="image" /></p>
            <p class="copy"><a href="javascript:;">Copy link</a></p>
            <p class="delete"><a href="javascript:;">Delete</a></p>
        </div>';
		
		return $str;
	}
}