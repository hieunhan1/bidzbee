<!--
	- button view form Add fields: btnFormAddField
    - ID form add fields general hidden: formAddField
    - class container: addFields
    - class fields active: addFieldsActive
    - class list fields: listAddFields
    - class form: frmAddFields
    - class fields type action: actionType
    - class field: fieldAddFields, fieldAddFieldsActive
    - button action: btnFieldsCreate, btnFieldsUpdate, btnFieldsDelete, btnFieldsCancel
-->
<div id="formAddField" class="hidden">
    <ul class="iAC-Collection" style="width:400px;">
        <li class="field" name="type" type="string" check="string" condition="1">
            <span class="label">Type</span>
            <ul class="values values80">
                <li class="field">
                    <p class="value">
                        <select name="type" class="field select actionType">
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
        <li class="field" name="name" type="string" check="user" condition="1">
            <span class="label">Name</span>
            <ul class="values values80">
                <li class="field">
                    <p class="value"><input type="text" name="name" value="" class="field input" /></p>
                </li>
                <p class="error hidden">Name is a required field</p>
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
        <li class="field maxlength" name="maxlength" type="string" check="number" condition="0">
            <span class="label">Max.Str</span>
            <ul class="values values80">
                <li class="field">
                    <p class="value"><input type="text" name="maxlength" value="" class="field input" /></p>
                </li>
                <p class="error hidden">Input number</p>
            </ul>
            <p class="clear1"></p>
        </li>
        <li class="field data addData" style="display:none;" name="data" type="datalist" check="string" condition="0">
            <span class="label">Data</span>
            <ul class="values values80 dataListFull listAddData sortable">
            	<p class="error hidden">Data is a required field</p>
            </ul>
            <div class="viewFrmAddData values80 floatRight">
            	<input type="button" name="btnAddData" value="Add" class="btnAddData btnSmall bgGreen corner5" />
            </div>
            <p class="clear5"></p>
        </li>
        
        <li class="field dataConnect" style="display:none;" name="connect" type="group" check="string" condition="0">
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
                <li class="field data addData" name="filter" type="datalist" check="string" condition="0">
                    <span class="label">Filter</span>
                    <ul class="values values80 dataListFull listAddData sortable"></ul>
                    <div class="viewFrmAddData values80 floatRight">
                        <input type="button" name="btnAddData" value="Add" class="btnAddData btnSmall bgGreen corner5" />
                    </div>
                    <p class="clear5"></p>
                </li>
            </ul>
        	<p class="clear5"></p>
        </li>
        
        <li class="field authority" name="authority" type="datalist" check="string" condition="0">
            <span class="label">Authority</span>
            <ul class="values values80 listAuthority">
            	<li class="field" name="groups" type="datalist">
                    <ul class="values valuesFull authorityGroup">
                    	
                    </ul>
                </li>
                <li class="field" name="users" type="datalist">
                    <ul class="values authorityUsers">
                    	
                    </ul>
                </li>
            </ul>
            <div class="viewFrmAuthority values80 floatRight">
            	<input type="button" name="btnAddAuthority" value="Add" class="btnAddAuthority btnSmall bgGreen corner5" />
            </div>
            <p class="clear5"></p>
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
        
        <div class="width80 floatRight">
            <input type="button" name="btnCreateFields" value="Create field" class="btnCreateFields btnMedium bgBlue corner5" />
            <input type="button" name="btnUpdateFields" value="Update field" class="btnUpdateFields btnMedium bgBlue corner5 hidden" />
            <input type="button" name="btnCancelFields" value="Cancel" class="btnCancelFields btnMedium bgGray corner5" />
            <input type="button" name="btnDeleteFields" value="Delete" class="btnDeleteFields btnMedium bgRed corner5 hidden" />
        </div>
        
    </ul>
</div>
<script type="text/javascript">
//function check type: text, phone, radio, select,...
function changeType(){
	var type = $("#ppContent .actionType").val();
	if(type=="radio" || type=="checkbox" || type=="select" || type=="datalist"){
		$("#ppContent .iAC-Collection").find(".data:first, .dataConnect:first").show();
		$("#ppContent .iAC-Collection").find(".maxlength:first").hide();
		ppAutoSize();
	}else{
		$("#ppContent .iAC-Collection").find(".data:first, .dataConnect:first").hide();
		$("#ppContent .iAC-Collection").find(".maxlength:first").show();
		ppAutoSize();
	}
	
	sortable();
}
$(document).ready(function() {
	//function object to string
	function objectToStringFields(object){
		if(typeof object != "object"){
			return false;
		}
		
		var name = object.name;
		var arrName = new Array();
		$(".addFieldsActive").children(".listAddFields").children(".field").each(function(index, element) {
            arrName[index] = $(element).attr("name");
        });
		if( arrName.indexOf(name)!=-1 && name!=$(".fieldAddFieldsActive").attr("name") ){
			alert('"' + name + '"' + ' already exists!');
			return false;
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
			
			if(count==0 && key!="name" && values!=null){
				str += '<li class="field" value="' + key + '" title="' + key + '">' + values + '</li>';
			}else if(count > 0){
				var data = objectToStringFields( values );
				str+= '<li class="field" name="' + key + '" type="datalist">';
					str+= '<ul class="values dataListFull">';
						str+= data;
						str+= '<p class="clear1"></p>';
					str+= '</ul>';
				str+= '</li>';
			}
		}
		
		return str;
	}
	
	//function view add fields
	function viewAddFields(name, strObject){
		var str = '';
		str = '<li class="field fieldAddFields" name="' + name + '" type="datalist">';
			str+= '<span class="label2">' + name + '</span>';
			str+= '<ul class="values values80 dataListFull" style="display:none">';
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
				var value = $(element).attr("value");
				var label = $(element).html();
				object[value] = label;
			}else if(typeof $(element).attr("name") != "undefined"){
				var name = $(element).attr("name");
				var value = $(element);
				object[name] = stringToObjectFields(value, false);
			}
        });
		
		return object;
	}
	
	//view string add data
	function objectToStringAddData(object){
		var str = '';
		for(var key in object){
			str+= '<li class="field fieldAddData" value="' + key + '" title="' + key + '">' + object[key] + '</li>';
		}
		return str;
	}
	
	//view string authority
	function objectToStringAuthority(object){
		var obj = new Object();
		if(object.group){
			obj.group = authorityObjectToString(object.group);
		}
		if(object.users){
			obj.users = authorityObjectToString(object.users);
		}
		return obj;
	}
	
	//get collection
	function getCollection(){
		var filter = new Object();
			filter.pretty = {_id:0, name:1, label:1, fields:1};
			filter.sort = {name:1};
		
		var fields = new Object();
			fields._collection = 'control';
			fields._action = 'read';
			fields.filter = filter;
			
		$.ajax({
			url: 'ajax',
			type: 'POST',
			data: fields,
			cache: false,
			success: function(data){
				data = $.parseJSON(data);
				if(data.result==false){
					console.log(data);
					return false;
				}
				
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
	
	//function set data to form
	function setDataToForm(object){
		var form = $("#formAddField").html();
		ppLoad(form);
		
		$("#ppContent .iAC-Collection").children(".field").each(function(index, element) {
            var name = $(element).attr("name");
			if(typeof object[name]!="undefined" && name!='connect'){
				if( $(element).find("input[name=" + name + "]").length ){
					$(element).find("input[name=" + name + "]").val(object[name]);
				}else if( $(element).find("select[name=" + name + "]").length ){
					$(element).find("select[name=" + name + "]").val(object[name]);
				}else if( $(element).children(".listAddData").length ){
					var str = objectToStringAddData(object[name]);
					$(element).children(".listAddData").append(str);
				}else if( $(element).children(".listAuthority").length ){
					var str = objectToStringAuthority(object[name]);
					$(element).find(".authorityGroup").html(str.group);
					$(element).find(".authorityUsers").html(str.users);
				}else{
					
				}
			}else if(typeof object[name]!="undefined" && name=='connect'){
				$(element).find("select[name=collection]").html('<option value="' + object[name].collection + '"></option>');
				$(element).find("select[name=value]").html('<option value="' + object[name].value + '"></option>');
				$(element).find("select[name=label]").html('<option value="' + object[name].label + '"></option>');
				
				var str = objectToStringAddData(object[name].filter);
				$(element).find(".listAddData").append(str);
			}
        });
	}
	
	//view form add fields
	$(".btnFormAddField").on("click", function(){
		$(".addFields").removeClass("addFieldsActive");
		$(this).parents(".addFields").addClass("addFieldsActive");
		var form = $("#formAddField").html();
		
		getCollection();
		ppLoad(form);
	});
	
	//create fields
	$("#ppContent").on("click", ".btnCreateFields", function(){
		var tags = $(this).parents(".iAC-Collection");
		var fields = checkGetData(tags);
		
		if(fields==false){
			return false;
		}
		
		var strObject = objectToStringFields(fields);
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
		
		var string = $(this).context;
		var object = stringToObjectFields(string);
		
		setDataToForm(object);
		getCollection();
		changeType();
		sortable();
		
		$("#ppContent .btnCreateFields").hide();
		$("#ppContent .btnUpdateFields").show();
		$("#ppContent .btnDeleteFields").show();
	});
	
	//update fields
	$("#ppContent").on("click", ".btnUpdateFields", function(){
		var tags = $(this).parents(".iAC-Collection");
		var fields = checkGetData(tags);
		
		if(fields==false){
			return false;
		}
		
		var strObject = objectToStringFields(fields);
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

<!--
	- button view form Add data: btnAddData
    - ID form add data general hidden: frmAddData
    - class container: addData
    - class list data: listAddData
    - class view form: viewFrmAddData
    - class form: frmAddData
    - class field: fieldAddData, fieldAddDataActive
    - button action: btnDataCreate, btnDataUpdate, btnDataDelete, btnDataCancel
-->
<div id="frmAddData" class="hidden">
	<div class="frmAddData">
        <p class="clear5"></p>
        <p class="width65"><i>Label:</i> <input type="text" name="label" value="" class="input" /></p>
        <p class="width65"><i>Value:</i> <input type="text" name="value" value="" class="input" /></p>
        <p class="clear5"></p>
        <p class="width65">
            <input type="button" name="btnDataCreate" value="Create" class="btnDataCreate btnSmall bgGreen corner5" />
            <input type="button" name="btnDataUpdate" value="Update" class="btnDataUpdate btnSmall bgGreen corner5 hidden" />
            <input type="button" name="btnDataCancel" value="Cancel" class="btnDataCancel btnSmall bgGray corner5" />
            <input type="button" name="btnDataDelete" value="Delete" class="btnDataDelete btnSmall bgRed corner5 hidden" />
        </p>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	//change type
	$("#ppContent").on("change", ".actionType", function(){
		changeType();
	});
	
	//function view form add data
	function viewFrmAddData(tags){
		var frm = $("#frmAddData").html();
		$(tags).parents(".addData").children(".viewFrmAddData").children(".btnAddData").hide();
		$(tags).parents(".addData").children(".viewFrmAddData").children(".frmAddData").remove();
		$(tags).parents(".addData").children(".viewFrmAddData").append(frm);
		
		ppAutoSize();
	}
	
	//function hidden form add data
	function hiddenFrmAddData(tags){
		$(tags).parents(".addData").children(".viewFrmAddData").children(".btnAddData").show();
		$(tags).parents(".addData").children(".viewFrmAddData").children(".frmAddData").remove();
		
		ppAutoSize();
	}
	
	//view form add data
	$("#ppContent").on("click", ".btnAddData", function(){
		viewFrmAddData(this);
	});
	
	//create data
	$("#ppContent").on("click", ".btnDataCreate", function(){
		var value = $(this).parents(".frmAddData").find("input[name=value]").val();
			value = $.trim(value);
		var label = $(this).parents(".frmAddData").find("input[name=label]").val();
			label = $.trim(label);
		
		if(value=="" || label==""){
			alert("Value and label not allow empty");
			return false;
		}
		
		var arrData = new Array();
		$(this).parents(".addData").children(".listAddData").children(".fieldAddData").each(function(index, element) {
            arrData[index] = $(element).attr("value");
        });
		if(arrData.indexOf(value) != -1){
			alert('"' + value + '"' + ' already exists!');
			return false;
		}
		
		var str = '<li class="field fieldAddData" value="' + value + '" title="' + value + '">' + label + '</li>';
		$(this).parents(".addData").children(".listAddData").append(str);
		
		hiddenFrmAddData(this);
	});
	
	//active data
	$("#ppContent").on("click", ".fieldAddData", function(){
		viewFrmAddData(this);
		
		$(".fieldAddData").removeClass("fieldAddDataActive");
		$(this).addClass("fieldAddDataActive");
		
		var value = $(this).attr("value");
		var label = $(this).html();
		
		$(this).parents(".addData").children(".viewFrmAddData").find("input[name=value]").val(value);
		$(this).parents(".addData").children(".viewFrmAddData").find("input[name=label]").val(label);
		
		$(this).parents(".addData").children(".viewFrmAddData").find(".btnDataCreate").hide();
		$(this).parents(".addData").children(".viewFrmAddData").find(".btnDataUpdate").show();
		$(this).parents(".addData").children(".viewFrmAddData").find(".btnDataDelete").show();
	});
	
	
	//update data
	$("#ppContent").on("click", ".btnDataUpdate", function(){
		var value = $(this).parents(".frmAddData").find("input[name=value]").val();
		var label = $(this).parents(".frmAddData").find("input[name=label]").val();
		
		if(value=="" || label==""){
			alert("Value and label not allow empty");
			return false;
		}
		
		var arrData = new Array();
		$(this).parents(".addData").children(".listAddData").children(".fieldAddData").each(function(index, element) {
            arrData[index] = $(element).attr("value");
        });
		if( arrData.indexOf(value)!=-1 && value!=$(".fieldAddDataActive").attr("value") ){
			alert('"' + value + '"' + ' already exists!');
			return false;
		}
		
		$(".fieldAddDataActive").attr("value", value);
		$(".fieldAddDataActive").html(label);
		
		hiddenFrmAddData(this);
	});
	
	//delete data
	$("#ppContent").on("click", ".btnDataDelete", function(){
		$(".fieldAddDataActive").remove();
		hiddenFrmAddData(this);
	});
	
	//cancel data
	$("#ppContent").on("click", ".btnDataCancel", function(){
		hiddenFrmAddData(this);
	});
});
</script>

<!--
	- button view form Add data: btnAddAuthority
    - ID form add data general hidden: frmAuthority
    - class container: authority
    - class list data: listAuthority
    - class view form: viewFrmAuthority
    - class form: frmAuthority
    - class field: fieldAuthority, fieldAuthorityActive
    - button action: btnAuthorityCreate, btnAuthorityUpdate, btnAuthorityDelete, btnAuthorityCancel
-->
<div id="frmAuthority" class="hidden">
	<div class="frmAuthority">
        <p class="width65">
            <select name="data" class="select">
            	<optgroup label="Group">
                    <option value="everyone" type="group">everyone</option>
                    <option value="users" type="group">users</option>
                    <option value="administrators" type="group">administrators</option>
                </optgroup>
            	<optgroup label="Users">
                    <option value="trannhan" type="user">trannhan</option>
                    <option value="admin" type="user">admin</option>
                </optgroup>
            </select>
        </p>
        <p class="clear10"></p>
        <p class="width65">
        	<b style="width:60px; float:left;">Read:</b>
        	<input type="radio" name="read" value="1" id="authorityRead1" checked="checked" /> Yes &nbsp; &nbsp; 
        	<input type="radio" name="read" value="0" id="authorityRead2" /> No
        </p>
        <p class="clear10"></p>
        <p class="width65">
        	<b style="width:60px; float:left;">Create:</b>
        	<input type="radio" name="create" value="1" id="authorityCreate1" checked="checked" /> Yes &nbsp; &nbsp; 
        	<input type="radio" name="create" value="0" id="authorityCreate2" /> No
        </p>
        <p class="clear10"></p>
        <p class="width65">
        	<b style="width:60px; float:left;">Update:</b>
        	<input type="radio" name="update" value="1" id="authorityUpdate1" checked="checked" /> Yes &nbsp; &nbsp; 
        	<input type="radio" name="update" value="0" id="authorityUpdate2" /> No
        </p>
        <p class="clear10"></p>
        <p class="width65">
        	<b style="width:60px; float:left;">Delete:</b>
        	<input type="radio" name="delete" value="1" id="authorityDelete1" /> Yes &nbsp; &nbsp; 
        	<input type="radio" name="delete" value="0" id="authorityDelete2" checked="checked" /> No
        </p>
        <p class="clear10"></p>
        <p class="width65">
            <input type="button" name="btnAuthorityCreate" value="Create" class="btnAuthorityCreate btnSmall bgGreen corner5" />
            <input type="button" name="btnAuthorityUpdate" value="Update" class="btnAuthorityUpdate btnSmall bgGreen corner5 hidden" />
            <input type="button" name="btnAuthorityCancel" value="Cancel" class="btnAuthorityCancel btnSmall bgGray corner5" />
            <input type="button" name="btnAuthorityDelete" value="Delete" class="btnAuthorityDelete btnSmall bgRed corner5 hidden" />
        </p>
        <p class="clear5"></p>
    </div>
</div>
<script type="text/javascript">
//function authority object to string
function authorityObjectToString(object){
	var str = '';
	for(var key in object){
		str += '<li class="field fieldAuthority" name="' + key + '" type="datalist">';
		str += '<span class="label2">' + key + '</span>';
		str += '<ul class="values" style="display:none">';
		
		var strValue = '';
		for(var value in object[key]){
			strValue += '<li class="field" value="' + value + '">' + object[key][value] + '</li>';
		}
		
		str += strValue;
		str += '</ul>';
		str +=' </li>';
	}
	
	return str;
}

$(document).ready(function() {
	//function view form add data
	function viewFrmAuthority(tags){
		var frm = $("#frmAuthority").html();
		$(tags).parents(".authority").children(".viewFrmAuthority").children(".btnAddAuthority").hide();
		$(tags).parents(".authority").children(".viewFrmAuthority").children(".frmAuthority").remove();
		$(tags).parents(".authority").children(".viewFrmAuthority").append(frm);
		
		ppAutoSize();
	}
	
	//function hidden form add data
	function hiddenFrmAuthority(tags){
		$(tags).parents(".authority").children(".viewFrmAuthority").children(".btnAddAuthority").show();
		$(tags).parents(".authority").children(".viewFrmAuthority").children(".frmAuthority").remove();
		
		ppAutoSize();
	}
	
	//view form add data
	$("#ppContent, .viewFrmAuthority").on("click", ".btnAddAuthority", function(){
		viewFrmAuthority(this);
	});
	
	//create data
	$("#ppContent, .authority").on("click", ".btnAuthorityCreate", function(){
		var name = $(this).parents(".frmAuthority").find("select[name=data]").val();
			name = $.trim(name);
		var type = $(this).parents(".frmAuthority").find("select[name=data] option:selected").attr("type");
			type = $.trim(type);
		var read = $(this).parents(".frmAuthority").find("input[name=read]:checked").val();
			read = parseInt($.trim(read));
		var create = $(this).parents(".frmAuthority").find("input[name=create]:checked").val();
			create = parseInt($.trim(create));
		var update = $(this).parents(".frmAuthority").find("input[name=update]:checked").val();
			update = parseInt($.trim(update));
		var del = $(this).parents(".frmAuthority").find("input[name=delete]:checked").val();
			del = parseInt($.trim(del));
		
		if(name=="" || type==""){
			alert("Value not allow empty");
			return false;
		}
		
		var data = new Object();
			data.read = read;
			data.create = create;
			data.update = update;
			data.delete = del;
		
		var object = new Object();
			object[name] = data;
		var str = authorityObjectToString(object);
		
		var arrData = new Array();
		$(this).parents(".authority").find(".authorityGroup").children(".field").each(function(index, element) {
            arrData[index] = $(element).attr("name");
        });
		if(arrData.indexOf(name) != -1){
			alert('"' + name + '"' + ' already exists!');
			return false;
		}
		
		if(type=='groups'){
			$(this).parents(".authority").find(".authorityGroup").append(str);
		}else{
			$(this).parents(".authority").find(".authorityUsers").append(str);
		}
		hiddenFrmAuthority(this);
	});
	
	//active data
	$("#ppContent, .authority").on("click", ".fieldAuthority", function(){
		viewFrmAuthority(this);
		
		$(".fieldAuthority").removeClass("fieldAuthorityActive");
		$(this).addClass("fieldAuthorityActive");
		
		var name = $(this).attr("name");
		var read = $(this).children(".values").children(".field:first").html();
		var create = $(this).children(".values").children(".field:eq(1)").html();
		var update = $(this).children(".values").children(".field:eq(2)").html();
		var del = $(this).children(".values").children(".field:eq(3)").html();
		
		$(this).parents(".authority").find("select[name=data]").val(name);
		$(this).parents(".authority").find("input[name=read][value=" + read + "]").attr("checked", true);
		$(this).parents(".authority").find("input[name=create][value=" + create + "]").attr("checked", true);
		$(this).parents(".authority").find("input[name=update][value=" + update + "]").attr("checked", true);
		$(this).parents(".authority").find("input[name=delete][value=" + del + "]").attr("checked", true);
		
		$(this).parents(".authority").find(".btnAuthorityCreate").hide();
		$(this).parents(".authority").find(".btnAuthorityUpdate").show();
		$(this).parents(".authority").find(".btnAuthorityDelete").show();
	});
	
	//update data
	$("#ppContent, .authority").on("click", ".btnAuthorityUpdate", function(){
		var name = $(this).parents(".frmAuthority").find("select[name=data]").val();
			name = $.trim(name);
		var type = $(this).parents(".frmAuthority").find("select[name=data] option:selected").attr("type");
			type = $.trim(type);
		var read = $(this).parents(".frmAuthority").find("input[name=read]:checked").val();
			read = parseInt($.trim(read));
		var create = $(this).parents(".frmAuthority").find("input[name=create]:checked").val();
			create = parseInt($.trim(create));
		var update = $(this).parents(".frmAuthority").find("input[name=update]:checked").val();
			update = parseInt($.trim(update));
		var del = $(this).parents(".frmAuthority").find("input[name=delete]:checked").val();
			del = parseInt($.trim(del));
		
		if(name=="" || type==""){
			alert("Value not allow empty");
			return false;
		}
		
		var data = new Object();
			data.read = read;
			data.create = create;
			data.update = update;
			data.delete = del;
		
		var object = new Object();
			object[name] = data;
		var str = authorityObjectToString(object);
		
		var arrData = new Array();
		$(this).parents(".authority").find(".authorityGroup").children(".field").each(function(index, element) {
            arrData[index] = $(element).attr("name");
        });
		if(arrData.indexOf(name)!=-1 && name!=$(".fieldAuthorityActive").attr("name")){
			alert('"' + name + '"' + ' already exists!');
			return false;
		}
		
		$(".fieldAuthorityActive").replaceWith(str);
		
		hiddenFrmAuthority(this);
	});
	
	//delete data
	$("#ppContent, .authority").on("click", ".btnAuthorityDelete", function(){
		$(".fieldAuthorityActive").remove();
		hiddenFrmAuthority(this);
	});
	
	//cancel data
	$("#ppContent, .authority").on("click", ".btnAuthorityCancel", function(){
		hiddenFrmAuthority(this);
	});
});
</script>