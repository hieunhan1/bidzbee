<!--
	- button view form Add fields: btnFormAddField
    - ID form add fields general hidden: formAddField
    - class container: addFields
    - class fields active: addFieldsActive
    - class list fields: listAddFields
    - class form: frmAddFields
    - ID fields type action: actionType
    - class field: fieldAddFields, fieldAddFieldsActive
    - button action: btnFieldsCreate, btnFieldsUpdate, btnFieldsDelete, btnFieldsCancel
-->
<div id="formAddField" class="hidden">
    <ul class="iAC-Collection" style="width:400px;">
        <li class="field" name="name" type="string" check="user" condition="1">
            <span class="label">Name</span>
            <ul class="values values80">
                <li class="field">
                    <p class="value"><select name="name" class="field select" id="fieldsName">
                    	
                    </select></p>
                </li>
                <p class="error hidden">Name is a required field</p>
            </ul>
            <p class="clear1"></p>
        </li>
        <li class="field" name="type" type="string" check="string" condition="1">
            <span class="label">Type</span>
            <ul class="values values80">
                <li class="field">
                    <p class="value">
                        <select name="type" class="field select" id="actionType">
                            <option value="text">Text</option>
                            <option value="date">Date</option>
                            <option value="datetime">Datetime</option>
                            <option value="tel">Telephone</option>
                            <option value="email">Email</option>
                            <option value="hidden">Hidden</option>
                            <option value="password">Password</option>
                            <option value="textarea">Text Area</option>
                            <option value="textckeditor">Text CKeditor</option>
                            <option value="radio">Radio</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="select">Select</option>
                            <option value="datalist">Data list</option>
                            <!--<option value="group">Group</option>-->
                            <option value="noaction">No action</option>
                        </select>
                    </p>
                </li>
                <p class="error hidden">Type is a required field</p>
            </ul>
            <p class="clear1"></p>
        </li>
        <li class="field" name="label" type="string" check="string" condition="0">
            <span class="label">Label</span>
            <ul class="values values80">
                <li class="field">
                    <p class="value"><input type="text" name="label" value="" class="field input" /></p>
                </li>
                <p class="error hidden">Label is a required field</p>
            </ul>
            <p class="clear1"></p>
        </li>
        <li class="field" name="check" type="string" check="string" condition="1">
            <span class="label">Check</span>
            <ul class="values values80">
                <li class="field">
                    <p class="value">
                        <select name="check" class="field select">
                            <option value="string">String</option>
                            <option value="number">Number</option>
                            <option value="tel">Telephone</option>
                            <option value="email">Email</option>
                            <option value="user">User</option>
                            <option value="date">Datetime</option>
                            <option value="confirm">Confirm</option>
                        </select>
                    </p>
                </li>
                <p class="error hidden">Check is a required field</p>
            </ul>
            <p class="clear1"></p>
        </li>
        <li class="field" name="condition" type="string" check="string" condition="0">
            <span class="label">Condition</span>
            <ul class="values values80">
                <li class="field">
                    <p class="value"><input type="text" name="condition" value="0" class="field input" /></p>
                </li>
                <p class="error hidden">Condition is a required field</p>
            </ul>
            <p class="clear1"></p>
        </li>
        <li class="field" name="error" type="string" check="string" condition="0">
            <span class="label">Error</span>
            <ul class="values values80">
                <li class="field">
                    <p class="value"><input type="text" name="error" value="" class="field input" /></p>
                </li>
                <p class="error hidden">Message error is a required field</p>
            </ul>
            <p class="clear1"></p>
        </li>
        <li class="field" name="notes" type="string" check="string" condition="0">
            <span class="label">Notes</span>
            <ul class="values values80">
                <li class="field">
                    <p class="value"><input type="text" name="notes" value="" class="field input" /></p>
                </li>
                <p class="error hidden">Notes error is a required field</p>
            </ul>
            <p class="clear1"></p>
        </li>
        <li class="field" name="view" type="string" check="string" condition="0">
            <span class="label">View</span>
            <ul class="values values80">
                <li class="field">
                    <p class="value">
                        <select name="view" class="field select">
                            <option value="">Width 50%</option>
                            <option value="values80">Width 80%</option>
                            <option value="valuesFull">Width Full</option>
                        </select>
                    </p>
                </li>
                <p class="error hidden">View is a required field</p>
            </ul>
            <p class="clear1"></p>
        </li>
        <li class="field" name="class" type="string" check="string" condition="0">
            <span class="label">Class</span>
            <ul class="values values80">
                <li class="field">
                    <p class="value"><input type="text" name="class" value="field" class="field input" /></p>
                </li>
                <p class="error hidden">Class is a required field</p>
            </ul>
            <p class="clear1"></p>
        </li>
        <li class="field" name="id" type="string" check="string" condition="0">
            <span class="label">ID css</span>
            <ul class="values values80">
                <li class="field">
                    <p class="value"><input type="text" name="id" value="" class="field input" /></p>
                </li>
                <p class="error hidden">ID is a required field</p>
            </ul>
            <p class="clear1"></p>
        </li>
        
        <li class="field addData hidden viewType" name="data" type="datalist" check="string" condition="0">
            <span class="label">Data</span>
            <ul class="values values80 dataListFull listAddData sortable">
            	<p class="error hidden">Data is a required field</p>
            </ul>
            <div class="viewFrmAddData values80 floatRight">
            	<input type="button" name="btnAddData" value="Add" class="btnAddData btnSmall bgGreen corner5" />
            </div>
            <p class="clear5"></p>
        </li>
        <li class="field dataConnect hidden viewType" name="connect" type="group" check="string" condition="0">
            <span class="label">Connect</span>
            <ul class="values values80">
            	<li class="field" name="collection" type="string" check="string" condition="0">
                    <ul class="values valuesFull">
                        <li class="field">
                            <p class="value"><select name="collection" class="field select"></select></p>
                        </li>
                    </ul>
                    <p class="clear1"></p>
                </li>
                <li class="field" name="value" type="string" check="string" condition="0">
                    <span class="label">Value</span>
                    <ul class="values values80">
                        <li class="field">
                            <p class="value"><select name="value" class="field select"></select></p>
                        </li>
                    </ul>
                    <p class="clear1"></p>
                </li>
                <li class="field" name="label" type="string" check="string" condition="0">
                    <span class="label">Label</span>
                    <ul class="values values80">
                        <li class="field">
                            <p class="value"><select name="label" class="field select"></select></p>
                        </li>
                    </ul>
                    <p class="clear1"></p>
                </li>
                <li class="field addData" name="where" type="datalist" check="string" condition="0">
                    <span class="label">Where</span>
                    <ul class="values values80 dataListFull listAddData sortable"></ul>
                    <div class="viewFrmAddData values80 floatRight">
                        <input type="button" name="btnAddData" value="Add" class="btnAddData btnSmall bgGreen corner5" />
                    </div>
                    <p class="clear5"></p>
                </li>
            </ul>
        	<p class="clear5"></p>
        </li>
        
        <div class="width80 floatRight" id="fieldsAdvanced">
        	<a href="javascript:;">Advanced</a>
            <p class="clear20"></p>
        </div>
        
        <li class="field addData properties hidden" name="properties" type="datalist" check="string" condition="0">
            <span class="label">Properties</span>
            <ul class="values values80 dataListFull listAddData sortable"></ul>
            <div class="viewFrmAddData values80 floatRight">
            	<input type="button" name="btnAddData" value="Add" class="btnAddData btnSmall bgGreen corner5" />
            </div>
            <p class="clear5"></p>
        </li>
    
        <li class="field authority hidden" name="authority" type="datalist" check="string" condition="0">
            <span class="label">Authority</span>
            <ul class="values listAuthority">
                <li class="field" name="groups" type="datalist">
                    <ul class="values valuesFull authorityGroup"></ul>
                </li>
                <li class="field" name="users" type="datalist">
                    <ul class="values valuesFull authorityUsers"></ul>
                </li>
            </ul>
            <div class="viewFrmAuthority values80 floatRight">
                <input type="button" name="btnAddAuthority" value="Add" class="btnAddAuthority btnSmall bgGreen corner5" />
            </div>
            <p class="clear5"></p>
        </li>
        
        <div class="width80 floatRight">
            <input type="button" name="btnCreateFields" value="Create field" class="btnCreateFields btnMedium bgBlue corner5" />
            <input type="button" name="btnUpdateFields" value="Update field" class="btnUpdateFields btnMedium bgBlue corner5 hidden" />
            <input type="button" name="btnCancelFields" value="Cancel" class="btnCancelFields btnMedium bgGray corner5" />
            <input type="button" name="btnDeleteFields" value="Delete" class="btnDeleteFields btnMedium bgRed corner5 hidden" />
        </div>
    </ul>
</div>
<div id="propertiesField" class="hidden">
	<select name="key" class="field select">
    	<option value="id">id</option>
    	<option value="class">class</option>
    	<option value="value">value</option>
    	<option value="maxlength">maxlength</option>
    	<option value="checked">checked</option>
    	<option value="selected">selected</option>
    	<option value="type">type</option>
    	<option value="view">view</option>
    	<option value="style">style</option>
    	<option value="placeholder">placeholder</option>
    	<option value="readonly">readonly</option>
    	<option value="disabled">disabled</option>
    	<option value="spellcheck">spellcheck</option>
    	<option value="title">title</option>
    </select>
</div>

<script type="text/javascript">
$(document).ready(function() {
	//get fields name
	function getFieldsName(){
		var str = '<option value="">-- select field --</option>';
		var fieldCurrent = $("#fieldsName").val();
		$("input[name=pretty]").each(function(index, element) {
            var field = $(element).val();
			if(field!=fieldCurrent){
				var selected = '';
			}else{
				var selected = ' selected="selected"';
			}
			str += '<option value="' + field + '"' + selected + '>' + field + '</option>';
        });
		
		$("#fieldsName").html(str);
	}
	
	//function check type: text, phone, radio, select,...
	function changeType(){
		var type = $("#ppContent #actionType").val();
		if(type=="radio" || type=="checkbox" || type=="select" || type=="datalist"){
			getCollectionDataConnect();
			$("#ppContent .viewType").show();
		}else{
			$("#ppContent .viewType").hide();
		}
		
		sortable();
	}
	
	//get collection
	function getCollectionDataConnect(){
		var filter = new Object();
			filter.pretty = {_id:0, name:1, label:1, fields:1};
			filter.sort = {name:1};
		
		var fields = new Object();
			fields._collection = 'collections';
			fields._action = 'read';
			fields._filter = filter;
			
		$.ajax({
			url: 'ajax',
			type: 'POST',
			data: fields,
			cache: false,
			success: function(data){
				data = convertToJson(data);
				if(data==false){
					console.log('ERROR: Server');
					return false;
				}else if(data.result==false){
					console.log(data.message);
					return false;
				}
				
				data = data.data;
				
				var currentCollection = $("#ppContent .dataConnect select[name=collection]").val();
				var currentValue = $("#ppContent .dataConnect select[name=value]").val();
				var currentLabel = $("#ppContent .dataConnect select[name=label]").val();
				
				var collectionString = '<option value="">- select collection -</option>';
				var fields = new Object();
				
				//get string collection
				for(var key in data){
					var name = data[key].name;
					if(name != currentCollection){
						var selected = '';
					}else{
						var selected = ' selected="selected"';
					}
					collectionString += '<option value="' + name + '"' + selected + '>' + data[key].label + '</option>';
					
					fields[name] = new Object();
					fields[name]._id = "_id";
					for(var field in data[key].fields){
						fields[name][field] = field;
					}
				}
				
				//gán string collection vào thẻ tags HTML
				$("#ppContent .dataConnect").find("select[name=collection]").html(collectionString);
				
				//gán string fields vào thẻ tags HTML
				$("#ppContent .dataConnect select[name=collection]").change(function(){
					var collection = $(this).val();
					var string = '<option value="">- select field -</option>';
					for(var field in fields[collection]){
						string += '<option value="' + field + '">' + field + '</option>';
					}
					$("#ppContent .dataConnect").find("select[name=value], select[name=label]").html(string);
				});
				
				if(currentCollection!=null){
					var valueString = '<option value="">- select field -</option>';
					var labelString = '<option value="">- select field -</option>';
					for(var field in fields[currentCollection]){
						if(field != currentValue){
							var selected = '';
						}else{
							var selected = ' selected="selected"';
						}
						valueString += '<option value="' + field + '"' + selected + '>' + field + '</option>';
					}
					for(var field in fields[currentCollection]){
						if(field != currentLabel){
							var selected = '';
						}else{
							var selected = ' selected="selected"';
						}
						labelString += '<option value="' + field + '"' + selected + '>' + field + '</option>';
					}
					
					$("#ppContent .dataConnect").find("select[name=value]").html(valueString);
					$("#ppContent .dataConnect").find("select[name=label]").html(labelString);
				}
			}
		});
	}
	
	//show fields advanced()
	function viewFieldsAdvanced(){
		$("#ppContent .properties, #ppContent .authority").hide(100);
		$("#ppContent").on("click", "#fieldsAdvanced", function(){
			$(this).hide();
			$("#ppContent .properties, #ppContent .authority").show(100);
		});
	}
	viewFieldsAdvanced();
	
	//get properties field
	function getPropertiesField(){
		$("#ppContent").on("click", ".properties .btnAddData, .properties .fieldAddData", function(){
			var str = $("#propertiesField").html();
			$(".properties .width65:first").html(str);
		});
	}
	getPropertiesField();
	
	//function object to string
	function objectToStringFields(object, check){
		if(typeof object != "object"){
			return false;
		}
		
		var name = object.name;
		
		if(check==true){
			var arrName = new Array();
			$(".addFieldsActive").children(".listAddFields").children(".field").each(function(index, element) {
				arrName[index] = $(element).attr("name");
			});
			if( arrName.indexOf(name)!=-1 && name!=$(".fieldAddFieldsActive").attr("name") ){
				alert('"' + name + '"' + ' already exists!');
				return false;
			}
		}
		
		var str = '';
		for(var key in object){
			values = object[key];
			
			var count = 0;
			if(typeof values == 'object'){
				for( var i in object[key]){
					count++;
				}
			}
			
			if(count==0 && values!=null && values!=""){
				str += '<li class="field" key="' + key + '" value="' + values + '">' + key + ' <i>(' + values + ')</i></li>';
			}else if(count > 0){
				var data = objectToStringFields( values );
				if(data!=""){
					str+= '<li class="field" name="' + key + '" type="datalist">';
						str+= '<ul class="values dataListFull">';
							str+= data;
							str+= '<p class="clear1"></p>';
						str+= '</ul>';
					str+= '</li>';
				}
			}
		}
		
		return str;
	}
	
	//function view add fields
	function viewAddFields(name, strObject){
		var str = '';
		str = '<li class="field fieldAddFields" name="' + name + '" type="datalist">';
			str+= '<span class="label2">' + name + '</span>';
			str+= '<ul class="values" style="display:none;">';
				str+= strObject;
			str+= '</ul>';
			str+= '<p class="clear1"></p>';
		str+= '</li>';
		
		return str;
	}
	
	//function string to object
	function stringToObjectFields(tags, getName){
		var object = new Object();
		
		if(getName != false){
			var name = $(tags).attr("name");
			object.name = name;
		}
		
		$(tags).children(".values").children(".field").each(function(index, element) {
            if(typeof $(element).attr("value") != "undefined"){
				var key = $(element).attr("key");
				var value = $(element).attr("value");
				object[key] = value;
			}else if(typeof $(element).attr("name") != "undefined"){
				var name = $(element).attr("name");
				var tags = $(element);
				object[name] = stringToObjectFields(tags, false);
			}
        });
		
		return object;
	}
	
	//view string add data
	function objectToStringAddData(object){
		var str = '';
		for(var key in object){
			str+= '<li class="field fieldAddData" key="' + key + '" value="' + object[key] + '">' + key + ' <i>(' + object[key] + ')</i></li>';
		}
		return str;
	}
	
	//function set data to form
	function setDataToForm(object){
		var form = $("#formAddField").html();
		ppLoad(form);
		
		$("#ppContent .iAC-Collection").children(".field").each(function(index, element) {
            var name = $(element).attr("name");
			if(typeof object[name]!="undefined" && name!='connect' && name!='authority'){
				if( $(element).find("input[name=" + name + "]").length ){
					$(element).find("input[name=" + name + "]").val(object[name]);
				}else if( $(element).find("select[name=" + name + "]").length ){
					$(element).find("select[name=" + name + "]").val(object[name]);
				}else if( $(element).children(".listAddData").length ){
					var str = objectToStringAddData(object[name]);
					$(element).children(".listAddData").append(str);
				}
			}else if(typeof object[name]!="undefined" && name=='connect'){
				$(element).find("select[name=collection]").html('<option value="' + object[name].collection + '"></option>');
				$(element).find("select[name=value]").html('<option value="' + object[name].value + '"></option>');
				$(element).find("select[name=label]").html('<option value="' + object[name].label + '"></option>');
				
				var str = objectToStringAddData(object[name].where);
				$(element).find(".listAddData").append(str);
			}else if(typeof object[name]!="undefined" && name=='authority'){
				var str = objectToStringAuthority(object[name]);
				$(element).find(".authorityGroup").html(str.groups);
				$(element).find(".authorityUsers").html(str.users);
			}
        });
	}
	
	//view string authority
	function objectToStringAuthority(object){
		var obj = new Object();
		if(object.groups){
			obj.groups = authorityObjectToString(object.groups);
		}
		if(object.users){
			obj.users = authorityObjectToString(object.users);
		}
		return obj;
	}
	
	//view form add fields
	$(".btnFormAddField").on("click", function(){
		getFieldsName();
		
		$(".addFields").removeClass("addFieldsActive");
		$(this).parents(".addFields").addClass("addFieldsActive");
		var form = $("#formAddField").html();
		
		ppLoad(form);
		
		$("#ppViewData").css({"height":"81%"});
	});
	
	//changeType
	$("#pp").on("change", "#actionType", function(){
		changeType();
	});
	
	//create fields
	$("#ppContent").on("click", ".btnCreateFields", function(){
		var tags = $(this).parents(".iAC-Collection");
		var fields = checkGetData(tags);
		
		if(fields==false){
			return false;
		}
		
		var strObject = objectToStringFields(fields, true);
		if(strObject==false){
			return false;
		}
		
		var str = viewAddFields(fields.name, strObject);
		
		$(".addFieldsActive .listAddFields").append(str);
		
		ppClose();
		autoSizeLeftRight();
	});
	
	//active fields
	$(".listAddFields").on("click", ".fieldAddFields", function(){
		$(".fieldAddFields").removeClass("fieldAddFieldsActive");
		$(this).addClass("fieldAddFieldsActive");
		
		getFieldsName();
		
		var string = $(this).context;
		var object = stringToObjectFields(string);
		
		setDataToForm(object);
		changeType()
		
		sortable();
		
		$("#ppContent .btnCreateFields").hide();
		$("#ppContent .btnUpdateFields").show();
		$("#ppContent .btnDeleteFields").show();
		
		$("#ppViewData").css({"height":"81%"});
	});
	
	//update fields
	$("#ppContent").on("click", ".btnUpdateFields", function(){
		var tags = $(this).parents(".iAC-Collection");
		var fields = checkGetData(tags);
		
		if(fields==false){
			return false;
		}
		
		var strObject = objectToStringFields(fields, true);
		if(strObject==false){
			return false;
		}
		
		var str = viewAddFields(fields.name, strObject);
		
		$(".fieldAddFieldsActive").replaceWith(str);
		
		$(".fieldAddFields").removeClass("fieldAddFieldsActive");
		
		ppClose();
		autoSizeLeftRight();
	});
	
	//delete fields
	$("#ppContent").on("click", ".btnDeleteFields", function(){
		$(".fieldAddFieldsActive").remove();
		ppClose();
	});
	
	//cancel fields
	$("#ppContent").on("click", ".btnCancelFields", function(){
		$(".fieldAddFields").removeClass("fieldAddFieldsActive");
		ppClose();
	});
});
</script>