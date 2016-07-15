<?php
class form{
	public function view($dataPages, $action, $data=array()){		
		$fieldsString = '';
		if( isset($dataPages['fields']) && is_array($dataPages['fields']) ){
			foreach($dataPages['fields'] as $name=>$field){
				$value = '';
				if(isset($data[$name])){
					$value = $data[$name];
				}
				
				$fieldsString .= $this->field($name, $field, $value);
			}
		}
		
		$_id = '0';
		if(isset($data['_id'])){
			$_id = $data['_id'];
		}
		
		$str = '<ul class="iAC-Collection" name="'.$dataPages['collection'].'" action="'.$action.'">
			<li class="field" name="_id" type="string" check="string" condition="0">
				<ul class="values">
					<li class="field">
						<p class="value"><input type="text" name="_id" value="'.$_id.'" class="field input hidden" /></p>
					</li>
				</ul>
			</li>
			'.$fieldsString.'
			<li class="field" name="submit" type="noaction">
				<span class="label"></span>
				<ul class="values">
					<p class="clear20"></p>
					<li class="field">
						<input type="button" name="iAC-Submit" value="Submit" class="iAC-Submit btnLarge bgBlue corner5" />
					</li>
				</ul>
			</li>
		</ul>
		
		<script type="text/javascript">
		$(document).ready(function() {
			ajaxSubmitFields();
		});
		</script>';
		
		return $str;
	}
	
	public function field($name, $field, $value){
		$arrProperties = array('name', 'type', 'check', 'condition', 'class', 'id');
		$properties = ' name="'.$name.'"';
		foreach($arrProperties as $key){
			if(isset($field[$key])){
				$properties .= ' '.$key.'="'.$field[$key].'"';
			}
		}
		
		$label = '';
		if(isset($field['label'])){
			$label = '<span class="label">'.$field['label'].'</span>';
		}
		
		$error = '';
		if(isset($field['error'])){
			$error = '<p class="error hidden">'.$field['error'].'</p>';
		}
		
		$notes = '';
		if(isset($field['notes'])){
			$notes = '<p class="notes">'.$field['notes'].'</p>';
		}
		
		$view = '';
		if(isset($field['view'])){
			$view = $field['view'];
		}
		
		$inputText = array('text', 'tel', 'email', 'hidden', 'password', 'noaction');
		$type = $field['type'];
		
		$result = '';
		if(in_array($type, $inputText)){
			$array = array('type', 'name', 'maxlength');
			$input = array(
				'type' => $type,
				'name' => $name,
				'value' => $value,
				'class' => 'field input',
			);
			if(isset($field['properties'])){
				foreach($field['properties'] as $k=>$v){
					if($k=='value' && $value!=''){
						$v = $value;
					}
					$input[$k] = $v;
				}
			}
			
			$result = $this->inputText($input);
		}else if($type=='textarea'){
			$input = array();
			$input['properties'] = array(
				'name' => $name,
				'class' => 'field text',
			);
			if(isset($field['properties'])){
				foreach($field['properties'] as $k=>$v){
					if($k!='value'){
						$input['properties'][$k] = $v;
					}else if($value==''){
						$value = $v;
					}
				}
			}
			$input['value'] = $value;
			
			$result = $this->textArea($input);
		}else if($type=='select'){
			$input = array();
			$input['properties'] = array(
				'name' => $name,
				'class' => 'field select',
			);
			if(isset($field['properties'])){
				foreach($field['properties'] as $k=>$v){
					if($k!='selected'){
						$input['properties'][$k] = $v;
					}else if($value==''){
						$value = $v;
					}
				}
			}
			
			if(isset($field['data'])){
				$input['data'] = $field['data'];
			}
			$input['value'] = $value;
			
			$result = $this->select($input);
		}else if($type=='radio' || $type=='checkbox'){
			$input = array();
			$input['properties'] = array(
				'type' => $type,
				'name' => $name,
				'class' => 'field',
			);
			if(isset($field['properties'])){
				foreach($field['properties'] as $k=>$v){
					if($k!='checked'){
						$input['properties'][$k] = $v;
					}else if($value==''){
						$value = $v;
					}
				}
			}
			
			if(isset($field['data'])){
				$input['data'] = $field['data'];
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
				'class' => 'field input datetimepicker',
			);
			if(isset($field['properties'])){
				foreach($field['properties'] as $k=>$v){
					if($k!='value'){
						$input['properties'][$k] = $v;
					}else if($value==''){
						$value = $v;
					}
				}
			}
			
			$result = $this->inputText($input);
		}else if($type=='date'){
			if($value!=''){
				$value = date(_DATE_, $value->sec);
			}
			$input = array(
				'type' => 'text',
				'name' => $name,
				'value' => $value,
				'class' => 'field input datepicker',
			);
			if(isset($field['properties'])){
				foreach($field['properties'] as $k=>$v){
					if($k!='value'){
						$input['properties'][$k] = $v;
					}else if($value==''){
						$value = $v;
					}
				}
			}
			
			$result = $this->inputText($input);
		}else if($type=='textckeditor'){
			$input = array();
			$input['properties'] = array(
				'name' => $name,
				'id' => $name.'_ck',
				'class' => 'field text',
			);
			if(isset($field['properties'])){
				foreach($field['properties'] as $k=>$v){
					if($k!='value'){
						$input['properties'][$k] = $v;
					}else if($value==''){
						$value = $v;
					}
				}
			}
			$input['value'] = $value;
			
			$result = $this->textCkeditor($input);
		}else if($type=='datalist'){
			if(is_array($value)){
				foreach($value as $key=>$row){
					$result .= '<p>'.$key.': <b>'.$row.'</b></p>';
				}
			}
		}
		
		$str = '<li'.$properties.'>
			'.$label.'
			<ul class="values '.$view.'">
				<li class="field">'.$result.'</li>
				'.$error.$notes.'
			</ul>
			<p class="clear1"></p>
		</li>';
		return $str;
	}
	
	private function inputText($input){
		$string = '';
		foreach($input as $key=>$value){
			$string .= ' '.$key.'="'.$value.'"';
		}
		
		$str = '<p class="value"><input '.$string.' /></p>';
		return $str;
	}
	
	private function inputList($input){
		$view = 'checkBoxFull';
		$properties = '';
		foreach($input['properties'] as $key=>$value){
			if($key!='view'){
				$properties .= ' '.$key.'="'.$value.'"';
			}else{
				$view = $value;
			}
		}
		
		$name = $input['properties']['name'];
		
		$i = 0;
		$str = '';
		if(isset($input['data'])){
			foreach($input['data'] as $key=>$label){
				$checked = '';
				if(isset($input['value']) && $key==$input['value']){
					$checked = 'checked="checked"';
				}
				$str .= '<span><input '.$properties.' value="'.$key.'" id="'.$name.$i.'" '.$checked.' />'.$label.'</span>';
				$i++;
			}
		}
		
		$str = '<p class="value '.$view.'">'.$str.'</p>';
		return $str;
	}
	
	private function textArea($input){
		$properties = '';
		foreach($input['properties'] as $key=>$value){
			$properties .= ' '.$key.'="'.$value.'"';
		}
		
		$value = $input['value'];
		
		$str = '<p class="value"><textarea'.$properties.'>'.$value.'</textarea></p>';
		return $str;
	}
	
	private function select($input){
		$properties = '';
		foreach($input['properties'] as $key=>$value){
			$properties .= ' '.$key.'="'.$value.'"';
		}
		
		$str = '';
		if(isset($input['data'])){
			foreach($input['data'] as $key=>$label){
				$selected = '';
				if(isset($input['value']) && $key==$input['value']){
					$selected = ' selected="selected"';
				}
				
				$str .= '<option value="'.$key.'"'.$selected.'>'.$label.'</option>';
			}
		}
		
		$str = '<p class="value"><select'.$properties.'>'.$str.'</select></p>';
		return $str;
	}
	
	private function textCkeditor($input){
		$properties = '';
		if(isset($input['properties'])){
			foreach($input['properties'] as $key=>$value){
				$properties .= ' '.$key.'="'.$value.'"';
			}
		}
		
		$value = $input['value'];
		
		$str = '<p class="value"><textarea'.$properties.'>'.$value.'</textarea></p>';
		
		$id = '';
		if(isset($input['properties']['id'])){
			$id = $input['properties']['id'];
		}
		$str .= $this->ckeditorFull($id);
		return $str;
	}
	
	private function ckeditorFull($name){
		$str = "<script>
		CKEDITOR.replace( '{$name}', {
			uiColor: '#E1E1E1',
			height: 400,
			pasteFromWordPromptCleanup: true,
			pasteFromWordRemoveFontStyles: true,
			forcePasteAsPlainText: true,
			ignoreEmptyParagraph: true,
			removeFormatAttributes: true,
			toolbar:
			[
			['Source','-','Maximize','ShowBlocks','-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
			['Undo','Redo','-','Find','Replace','-','RemoveFormat'],
			['Link','Unlink','Iframe'],
			['Image','Flash', 'Video', 'Table'],
			['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
			'/',
			['Styles','Format','Font','FontSize'],
			['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
			['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
			['TextColor','BGColor','-','HorizontalRule','Smiley','SpecialChar','PageBreak']
			]
			});
		</script>";
		return $str;
	}
	
	public function ckeditorStandard($name){
		$str = "<script>
		CKEDITOR.replace( '{$name}', {
			uiColor: '#E1E1E1',
			height: 250,
			pasteFromWordPromptCleanup: true,
			pasteFromWordRemoveFontStyles: true,
			forcePasteAsPlainText: true,
			ignoreEmptyParagraph: true,
			removeFormatAttributes: true,
			toolbar:
			[
			['Source','-','Maximize','ShowBlocks','PasteText','PasteFromWord','RemoveFormat'],
			['Link','Unlink','Iframe'],
			['Image','Flash', 'Video', 'Table'],
			['NumberedList','BulletedList','-','Outdent','Indent'],
			['TextColor','BGColor','-','HorizontalRule','SpecialChar','PageBreak'],
			['Format','Font','FontSize'],
			['Bold','Italic','Underline'],
			['JustifyLeft','JustifyCenter','JustifyRight'],
			]
			});
		</script>";
		return $str;
	}

	public function ckeditorBasic($name, $other=NULL){
		$str = "<script>
		CKEDITOR.replace( '{$name}', {
			uiColor: '#E1E1E1',
			height: 120,
			pasteFromWordPromptCleanup: true,
			pasteFromWordRemoveFontStyles: true,
			forcePasteAsPlainText: true,
			ignoreEmptyParagraph: true,
			removeFormatAttributes: true,
			toolbar: [
				['Source','Paste','PasteText','PasteFromWord','Bold', 'Italic', '-','RemoveFormat','TextColor','BGColor','NumberedList','BulletedList','-','Outdent','Indent',".$other."],
			]
		});
		</script>";
		return $str;
	}
}
?>