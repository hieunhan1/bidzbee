<?php
class formSearch{
	private $model;
	
	public function view($model, $dataPages){		
		$this->model = $model;
		
		$data = $_GET;
		
		$fieldsString = '';
		if( isset($dataPages['search']) && is_array($dataPages['search']) ){
			foreach($dataPages['search'] as $name=>$field){
				$value = '';
				if(isset($data[$name])){
					$value = $data[$name];
				}
				$fieldsString .= $this->field($name, $field, $value);
			}
		}
		
		$str = '<div class="frmSearch" name="'.$dataPages['collection'].'">
			'.$fieldsString.'
			<p class="item"><input type="button" name="btnSearch" class="btnSearch btnSmall bgGreen corner5" value="Search" /></p>
		</div>
		<script type="text/javascript"> btnAjaxSearch(); </script>';
		
		return $str;
	}
	
	public function field($name, $field, $value){
		$inputText = array('text', 'tel', 'email', 'hidden', 'password', 'noaction');
		$type = $field['type'];
		
		$result = '';
		if(in_array($type, $inputText)){
			$input = array(
				'type' => $type,
				'name' => $name,
				'value' => $value,
				'class' => 'input',
			);
			
			if(isset($field['label'])){
				$input['placeholder'] = $field['label'];
			}
			
			$result = $this->inputText($input);
		}else if($type=='select'){
			$input = array();
			$input['properties'] = array(
				'name' => $name,
				'class' => 'select',
			);
			
			if(isset($field['data'])){
				$input['data'] = $field['data'];
			}
			
			if(isset($field['connect'])){
				$input['connect'] = $field['connect'];
			}
			
			$input['value'] = $value;
			
			$result = $this->select($input);
		}else if($type=='radio' || $type=='checkbox'){
			$input = array();
			$input['properties'] = array(
				'type' => $type,
				'name' => $name,
				'class' => 'radio',
			);
			
			if(isset($field['data'])){
				$input['data'] = $field['data'];
			}
			
			if(isset($field['connect'])){
				$input['connect'] = $field['connect'];
			}
			
			$input['value'] = $value;
			
			$result = $this->inputList($input);
		}else if($type=='datetime'){
			if($value!=''){
				$value = date(_DATETIME_, $value->sec);
			}
			$input = array(
				'type' => 'text',
				'name' => $name,
				'value' => $value,
				'class' => 'input datetimepicker',
			);
			
			$result = $this->inputText($input);
		}else if($type=='date'){
			if($value!=''){
				$value = date(_DATE_, $value->sec);
			}
			$input = array(
				'type' => 'text',
				'name' => $name,
				'value' => $value,
				'class' => 'input datepicker',
			);
			
			$result = $this->inputText($input);
		}
		
		return $result;
	}
	
	private function inputText($input){
		$string = '';
		foreach($input as $key=>$value){
			$string .= ' '.$key.'="'.$value.'"';
		}
		
		$str = '<p class="item"><input '.$string.' /></p>';
		return $str;
	}
	
	private function arrayDataConnect($input){
		$array = array();
		if(isset($input['data'])){
			foreach($input['data'] as $value=>$label){
				$check = false;
				if(isset($input['value'])){
					if(!is_array($input['value']) && $input['value']==$value){
						$check = true;
					}else if(is_array($input['value']) && in_array($value, $input['value'])){
						$check = true;
					}
				}
				$array[] = array('value'=>$value, 'label'=>$label, 'check'=>$check);
			}
		}
		
		if(isset($input['connect'])){
			$filter = $this->model->_getCollectionFilter($input['connect']);
			
			$collection = $input['connect']['collection'];
			$v = $input['connect']['value'];
			$l = $input['connect']['label'];
			
			$filter['pretty'] = array(
				$v => 1,
				$l => 1,
			);
			$data = $this->model->find($collection, $filter);
			foreach($data as $field){
				$value = $field[$v];
				$label = $field[$l];
				
				$check = false;
				if(isset($input['value'])){
					if(!is_array($input['value']) && $input['value']==$value){
						$check = true;
					}else{
						if(is_array($input['value']) && in_array($value, $input['value'])){
							$check = true;
						}
					}
				}
				$array[] = array('value'=>$value, 'label'=>$label, 'check'=>$check);
			}
		}
		
		return $array;
	}
	
	private function inputList($input){
		$properties = '';
		foreach($input['properties'] as $key=>$value){
			$properties .= ' '.$key.'="'.$value.'"';
		}
		
		$name = $input['properties']['name'];
		unset($input['properties']);
		
		$str = ''; $i = 0;
		$array = $this->arrayDataConnect($input);
		foreach($array as $key=>$row){
			$check = '';
			if($row['check']==true){
				$check = 'checked="checked"';
			}
			$str .= '<span><input '.$properties.' value="'.$row['value'].'" id="'.$name.$i.'" '.$check.' />'.$row['label'].'</span>';
			$i++;
		}
		
		return '<p class="item radio">'.$str.'</p>';
	}
	
	private function select($input){
		$properties = '';
		foreach($input['properties'] as $key=>$value){
			$properties .= ' '.$key.'="'.$value.'"';
		}
		
		$str = '';
		$array = $this->arrayDataConnect($input);
		foreach($array as $key=>$row){
			$check = '';
			if($row['check']==true){
				$check = ' selected="selected"';
			}
			$str .= '<option value="'.$row['value'].'"'.$check.'>'.$row['label'].'</option>';
		}
		
		$str = '<p class="item"><select'.$properties.'>'.$str.'</select></p>';
		return $str;
	}
}
?>