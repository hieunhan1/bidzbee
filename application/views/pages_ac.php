<?php
$collection = _PAGES_;
$filter = array(
	'where' => array('_id'=>$_GET['_id']),
);
$data = $this->model->findOne($collection, $filter);
?>
<ul class="iAC-Collection" name="<?php echo $collection;?>" action="<?php echo $this->action;?>">
	<li class="field" name="_id" type="text" check="string" condition="0">
        <ul class="values">
            <li class="field">
                <p class="value"><input type="text" name="_id" value="<?php echo $data['_id'];?>" class="field input hidden" /></p>
            </li>
        </ul>
    </li>
    
	<li class="field" name="status" type="checkbox" check="string" condition="1">
        <span class="label">Status</span>
        <ul class="values">
            <li class="field">
                <p class="value checkBox">
                	<span><input type="radio" name="status" value="1" id="status1" class="field" checked="checked" />Enable</span>
                	<span><input type="radio" name="status" value="0" id="status0" class="field" <?php if(isset($data['status']) && $data['status']==0) echo 'checked="checked"';?> />Disable</span>
                </p>
                <p class="clear1"></p>
            </li>
            <p class="error hidden">Select status</p>
        </ul>
        <p class="clear10"></p>
    </li>
    
	<li class="field" name="type" type="checkbox" check="string" condition="1">
        <span class="label">Type page</span>
        <ul class="values">
            <li class="field">
                <p class="value checkBox">
                	<?php
                    	$types = array('web', 'admin');
						foreach($types as $i=>$type){
							$checked = '';
							if(isset($data['type']) && $data['type']==$type){
								$checked = 'checked="checked"';
							}else if($type=='web'){
								$checked = 'checked="checked"';
							}
							echo '<span><input type="radio" name="type" value="'.$type.'" id="type'.$i.'" class="field" '.$checked.' />'.ucfirst($type).'</span>';
						}
					?>
                </p>
                <p class="clear1"></p>
            </li>
            <p class="error hidden">Select type</p>
        </ul>
        <p class="clear10"></p>
    </li>
    
    <li class="field" name="label" type="text" check="string" condition="1">
        <span class="label">Label</span>
        <ul class="values">
            <li class="field">
                <p class="value"><input type="text" name="label" value="<?php echo $data['label'];?>" class="field input" /></p>
            </li>
            <p class="error hidden">Label name is a required field</p>
        </ul>
        <p class="clear1"></p>
    </li>
    
    <li class="field" name="name" type="text" check="string" condition="1">
        <span class="label">Page name</span>
        <ul class="values">
            <li class="field">
                <p class="value"><input type="text" name="name" value="<?php echo $data['name'];?>" class="field input" /></p>
            </li>
            <p class="error hidden">Page name is a required field</p>
        </ul>
        <p class="clear1"></p>
    </li>
    
    <li class="field admin" name="icon" type="text" check="string" condition="0">
        <span class="label">Icon</span>
        <ul class="values">
            <li class="field">
                <p class="value"><input type="text" name="name" value="<?php if(isset($data['icon'])) echo $data['icon']; else echo 'iconDefault';?>" class="field input" /></p>
            </li>
            <p class="error hidden">Icon is a required field</p>
        </ul>
        <p class="clear1"></p>
    </li>
    
    <li class="field" name="order" type="text" check="number" condition="0">
        <span class="label">Order</span>
        <ul class="values">
            <li class="field">
                <p class="value"><input type="text" name="name" value="<?php if(isset($data['order'])) echo $data['order']; else echo 0;?>" class="field input" /></p>
            </li>
            <p class="error hidden">Input number</p>
        </ul>
        <p class="clear1"></p>
    </li>
    
    <li class="field" name="collection" type="select" check="string" condition="0">
        <span class="label">Collection</span>
        <ul class="values">
            <li class="field">
                <p class="value">
                    <select name="collection" class="field select" id="collectionPages">
                    <?php if(isset($data['collection'])) echo '<option value="'.$data['collection'].'">'.$data['collection'].'</option>';?>
                    </select>
                </p>
            </li>
            <p class="error hidden">Collection is a required field</p>
        </ul>
        <p class="clear1"></p>
    </li>
    
    <li class="field" name="pretty" type="checkbox" check="string" condition="0">
        <span class="label">Pretty</span>
        <ul class="values">
            <li class="field">
                <p class="value checkBox" id="checkBox">
                	<?php
                    if(isset($data['pretty']) && is_array($data['pretty'])){
						foreach($data['pretty'] as $value){
							echo '<span><input type="checkbox" name="pretty" value="'.$value.'" class="field" checked="checked">'.$value.'</span>';
						}
					}else if(isset($data['pretty']) && $data['pretty']!=''){
						echo '<span><input type="checkbox" name="pretty" value="'.$data['pretty'].'" class="field" checked="checked">'.$data['pretty'].'</span>';
					}
					?>
                </p>
                <p class="clear1"></p>
            </li>
            <p class="error hidden">Pretty is a required field</p>
        </ul>
        <p class="clear10"></p>
    </li>
    
    <li class="field addData" name="where" type="datalist" check="string" condition="0">
        <span class="label">Where</span>
        <ul class="values dataListFull listAddData sortable">
            <p><a href="javascript:;" class="ppWhere">example</a></p>
            <?php
            if(isset($data['where'])){
				if(is_array($data['where'])){
					foreach($data['where'] as $key=>$value){
						echo '<li class="field fieldAddData" key="'.$key.'" value="'.$value.'">'.$key.' <i>('.$value.')</i></li>';
					}
				}
			}
			?>
        </ul>
        <div class="viewFrmAddData values80 floatRight">
            <input type="button" name="btnAddData" value="Add" class="btnAddData btnSmall bgGreen corner5" />
        </div>
        <p class="clear10"></p>
    </li>
    
    <li class="field addData" name="sort" type="datalist" check="string" condition="0">
        <span class="label">Sort</span>
        <ul class="values dataListFull listAddData sortable">
            <p class="error hidden">Sort is a required field</p>
            <?php
            if(isset($data['sort'])){
				if(is_array($data['sort'])){
					foreach($data['sort'] as $key=>$value){
						echo '<li class="field fieldAddData" key="'.$key.'" value="'.$value.'">'.$key.' <i>('.$value.')</i></li>';
					}
				}
			}
			?>
        </ul>
        <div class="viewFrmAddData values80 floatRight">
            <input type="button" name="btnAddData" value="Add" class="btnAddData btnSmall bgGreen corner5" />
        </div>
        <p class="clear10"></p>
    </li>
    
    <li class="field" name="limit" type="text" check="number" condition="0">
        <span class="label">Limit</span>
        <ul class="values">
            <li class="field">
                <p class="value"><input type="text" name="limit" value="<?php if(isset($data['limit'])) echo $data['limit'];?>" class="field input" /></p>
            </li>
            <p class="error hidden">Limit is a required field</p>
        </ul>
        <p class="clear1"></p>
    </li>
    
    <p class="clear1" style="background-color:#FC0;"></p><p class="clear10"></p>
    
    <li class="field addData" name="widgets" type="datalist" check="string" condition="0">
        <span class="label">Widgets</span>
        <ul class="values dataListFull listAddData sortable">
            <p class="error hidden">Widgets is a required field</p>
            <?php
            if(isset($data['widgets'])){
				if(is_array($data['widgets'])){
					foreach($data['widgets'] as $key=>$value){
						echo '<li class="field fieldAddData" key="'.$key.'" value="'.$value.'">'.$key.' <i>('.$value.')</i></li>';
					}
				}
			}
			?>
        </ul>
        <div class="viewFrmAddData values80 floatRight">
            <input type="button" name="btnAddData" value="Add" class="btnAddData btnSmall bgGreen corner5" />
        </div>
        <p class="clear10"></p>
    </li>
    
    <p class="clear1" style="background-color:#FC0;"></p><p class="clear10"></p>
    
    <li class="field web" name="php" type="textarea" check="string" condition="0">
        <span class="label">PHP</span>
        <ul class="values values80">
            <li class="field">
                <p class="value"><textarea name="php" class="field text" style="height:200px;"><?php if(isset($data['php'])) echo $data['php'];?></textarea></p>
            </li>
            <p class="error hidden">PHP is a required field</p>
        </ul>
        <p class="clear1"></p>
    </li>
    
    <li class="field web" name="html" type="textarea" check="string" condition="0">
        <span class="label">HTML</span>
        <ul class="values values80">
            <li class="field">
                <p class="value"><textarea name="html" class="field text" style="height:200px;"><?php echo $data['html'];?></textarea></p>
            </li>
            <p class="error hidden">HTML is a required field</p>
        </ul>
        <p class="clear1"></p>
    </li>
    
    <li class="field web" name="css" type="textarea" check="string" condition="0">
        <span class="label">CSS</span>
        <ul class="values values80">
            <li class="field">
                <p class="value"><textarea name="css" class="field text css-responsive" style="height:200px;"><?php if(isset($data['css'])) echo $data['css'];?></textarea></p>
                <p style="margin:10px 0"><span class="btnSmall bgGray corner3 btnResponsive">Load default responsive</span></p>
            </li>
            <p class="error hidden">CSS is a required field</p>
        </ul>
        <p class="clear1"></p>
    </li>
    
    <li class="field web" name="javascript" type="textarea" check="string" condition="0">
        <span class="label">Javascript</span>
        <ul class="values values80">
            <li class="field">
                <p class="value"><textarea name="javascript" class="field text" style="height:200px;"><?php if(isset($data['javascript'])) echo $data['javascript'];?></textarea></p>
            </li>
            <p class="error hidden">Javascript is a required field</p>
        </ul>
        <p class="clear1"></p>
    </li>
    
    <p class="clear1 admin" style="background-color:#FC0;"></p><p class="clear10"></p>
    
    <!--
    <li class="field admin" name="php_admin" type="textarea" check="string" condition="0">
        <span class="label">PHP admin</span>
        <ul class="values values80">
            <li class="field">
                <p class="value"><textarea name="php_admin" class="field text" style="height:200px;"><?php if(isset($data['php_admin'])) echo $data['php_admin'];?></textarea></p>
            </li>
            <p class="error hidden">PHP admin is a required field</p>
        </ul>
        <p class="clear1"></p>
    </li>
    
    <li class="field admin" name="html_admin" type="textarea" check="string" condition="0">
        <span class="label">HTML Admin</span>
        <ul class="values values80">
            <li class="field">
                <p class="value"><textarea name="html_admin" class="field text" style="height:200px;"><?php if(isset($data['html_admin'])) echo $data['html_admin'];?></textarea></p>
            </li>
            <p class="error hidden">HTML Admin is a required field</p>
        </ul>
        <p class="clear1"></p>
    </li>
    
    <li class="field admin" name="css_admin" type="textarea" check="string" condition="0">
        <span class="label">CSS admin</span>
        <ul class="values values80">
            <li class="field">
                <p class="value"><textarea name="css_admin" class="field text" style="height:200px;"><?php if(isset($data['css_admin'])) echo $data['css_admin'];?></textarea></p>
            </li>
            <p class="error hidden">CSS admin is a required field</p>
        </ul>
        <p class="clear1"></p>
    </li>
    
    <li class="field admin" name="javascript_admin" type="textarea" check="string" condition="0">
        <span class="label">Javascript admin</span>
        <ul class="values values80">
            <li class="field">
                <p class="value"><textarea name="javascript_admin" class="field text" style="height:200px;"><?php if(isset($data['javascript_admin'])) echo $data['javascript_admin'];?></textarea></p>
            </li>
            <p class="error hidden">Javascript admin is a required field</p>
        </ul>
        <p class="clear1"></p>
    </li>
    -->
    
    <li class="field addFields admin" name="fields" type="datalist" check="string" condition="0">
    	<span class="label">Fields</span>
        <ul class="values dataListFull listAddFields sortable">
            <?php
			function fieldArrayToString($data){
				$str = '';
				if(is_array($data) && count($data)>0){
					foreach($data as $key=>$value){
						if(!is_array($value)){
							$str .= '<li class="field" key="'.$key.'" value="'.$value.'">'.$key.' <i>('.$value.')</i></li>';
						}else{
							$children = fieldArrayToString($value);
							$str .= '<li class="field" name="'.$key.'" type="datalist">
								<ul class="values dataListFull">
									'.$children.'
									<p class="clear1"></p>
								</ul>
							</li>';
						}
					}
				}
				
				return $str;
			}
			
			$str = '';
			if(isset($data['fields']) && is_array($data['fields'])){
				foreach($data['fields'] as $name=>$row){
					$fields = fieldArrayToString($row);
					$str .= '<li class="field fieldAddFields" name="'.$name.'" type="datalist">
						<span class="label2">'.$name.'</span>
						<ul class="values values80 dataListFull" style="display:none">
							'.$fields.'
						</ul>
						<p class="clear1"></p>
					</li>';
				}
			}
			
			echo $str;
			?>
        </ul>
        <div class="viewFrmAddFields values80 floatRight">
            <input type="button" name="btnFormAddField" value="Add" class="btnFormAddField btnSmall bgGreen corner5" />
        </div>
        <p class="clear10"></p>
    </li>
    
    <li class="field" name="upload" type="checkbox" check="string" condition="0">
        <span class="label">Form upload</span>
        <ul class="values">
            <li class="field">
                <p class="value checkBox">
                	<span><input type="radio" name="upload" value="1" id="upload1" class="field" checked="checked" />Yes</span>
                	<span><input type="radio" name="upload" value="0" id="upload0" class="field" <?php if(isset($data['upload']) && $data['upload']==0) echo 'checked="checked"';?> />No</span>
                </p>
                <p class="clear1"></p>
            </li>
            <p class="error hidden">Select upload</p>
        </ul>
        <p class="clear10"></p>
    </li>
    
    <p class="clear1" style="background-color:#FC0;"></p><p class="clear10"></p>
    
    <li class="field authority" name="authority" type="datalist" check="string" condition="0">
        <span class="label">Authority</span>
        <ul class="values listAuthority">
            <li class="field" name="groups" type="datalist">
                <ul class="values valuesFull authorityGroup">
                    <?php
					if(isset($data['authority']['groups']) && is_array($data['authority']['groups'])){
						$dataAuth = $data['authority']['groups'];
						foreach($dataAuth as $name=>$allows){
							$str = '';
							foreach($allows as $key=>$value){
								$str .= '<li class="field" key="'.$key.'" value="'.$value.'">'.$key.' <i>('.$value.')</i></li>';
							}
							echo '<li class="field fieldAuthority" name="'.$name.'" type="datalist">
								<span class="label2">'.$name.'</span>
								<ul class="values" style="display:none">
									'.$str.'
								</ul>
							</li>';
						}
					}
					?>
                </ul>
            </li>
            <li class="field" name="users" type="datalist">
                <ul class="values valuesFull authorityUsers">
                    <?php
					if(isset($data['authority']['users']) && is_array($data['authority']['users'])){
						$dataAuth = $data['authority']['users'];
						foreach($dataAuth as $name=>$allows){
							$str = '';
							foreach($allows as $key=>$value){
								$str .= '<li class="field" key="'.$key.'" value="'.$value.'">'.$key.' <i>('.$value.')</i></li>';
							}
							echo '<li class="field fieldAuthority" name="'.$name.'" type="datalist">
								<span class="label2">'.$name.'</span>
								<ul class="values" style="display:none">
									'.$str.'
								</ul>
							</li>';
						}
					}
					?>
                </ul>
            </li>
        </ul>
        <div class="viewFrmAuthority values80 floatRight">
            <input type="button" name="btnAddAuthority" value="Add" class="btnAddAuthority btnSmall bgGreen corner5" />
        </div>
        <p class="clear5"></p>
    </li>
    
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

<?php
include_once('btnAddData.php');
include_once('authority.php');
include_once('ppWhere.php');
include_once('pages_add_fields.php');
?>

<style type="text/css">
.text{
	line-height: 150% !important;
	letter-spacing: 1px;
	padding: 3px !important;
}
</style>

<script type="text/javascript">
$(document).ready(function() {
	//load type web || admin
	function autoLoadType(){
		var type = $("input[name=type]:checked").val();
		if(type=="web"){
			$(".web").show();
			$(".admin").hide();
		}else{
			$(".web").show();
			$(".admin").show();
		}
	}
	autoLoadType();
	$("input[name=type]").change(function(){
		autoLoadType();
	});
	
	//load collection
	function autoLoadCollection(){
		var selected = $("#collectionPages").val();
		var checked = new Object();
		$("input[name=pretty]:checked").each(function(index, element) {
			var value = $(element).val();
            checked[value] = value;
        });
		
		var filter = new Object();
			filter.pretty = {_id:0, name:1, label:1, fields:1};
		var fields = new Object();
			fields._collection = '<?php echo _COLLECTION_;?>';
			fields._action = 'read';
			fields.filter = filter;
		$.ajax({ 	
			url     : 'ajax',
			type    : 'post',
			data    : fields,
			cache   : false,
			success : function(data){
				data = convertToJson(data);
				if(data==false) return false;
				
				data = data.data;
				var str = '<option value="">-- select collection --</option>';
				for(var key in data){
					if(data[key].name != selected){
						var select = '';
					}else{
						var select = ' selected="selected"';
						var pretty = data[key].fields;
						var strPretty = '';
						for(var i in pretty){
							if(!checked[i]){
								var strCheck = '';
							}else{
								var strCheck = ' checked="checked"';
							}
							strPretty += '<span><input type="checkbox" name="pretty" value="' + i + '" class="field"' + strCheck + ' />' + i + '</span>';
						}
						$("#checkBox").html(strPretty);
					}
					str += '<option value="' + data[key].name + '"' + select + '>' + data[key].label + '</option>';
				}
				$("#collectionPages").html(str);
			}
		});
	}
	autoLoadCollection();
	$("#collectionPages").change(function(){
		autoLoadCollection();
	});
	
	//load responsive
	function autoLoadResponsive(){
		$(".btnResponsive").click(function(){
			var str = '/*mobile*/\n';
				str+= '@media all and (min-width: 320px) {\n\n';
				str+= '}\n\n';
				str+= '/*tablet*/\n';
				str+= '@media all and (min-width: 600px) {\n\n';
				str+= '}\n\n';
				str+= '/*desktop*/\n';
				str+= '@media all and (min-width: 1024px) {\n\n';
				str+= '}';
				
			$(".css-responsive").val(str);
		});
	}
	autoLoadResponsive();
	
	//submit
	ajaxSubmitFields();
});
</script>