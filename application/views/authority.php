<!--
	- button view form authority: btnAddAuthority
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
                    <option value="everyone" type="groups">everyone</option>
                    <option value="users" type="groups">users</option>
                    <option value="administrators" type="groups">administrators</option>
                </optgroup>
            	<optgroup label="Users">
                    <option value="trannhan" type="users">trannhan</option>
                    <option value="admin" type="users">admin</option>
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
	for(var field in object){
		str += '<li class="field fieldAuthority" name="' + field + '" type="datalist">';
		str += '<span class="label2">' + field + '</span>';
		str += '<ul class="values" style="display:none">';
		
		var strValue = '';
		for(var key in object[field]){
			var value = object[field][key];
			strValue += '<li class="field" key="' + key + '" value="' + value + '">' + key + ' <i>(' + value + ')</i></li>';
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
		$(".authority").removeClass("authorityActive");
		$(tags).parents(".authority").addClass("authorityActive");
		
		$(".authorityActive").find(".btnAddAuthority").hide();
		$(".authorityActive").find(".frmAuthority").remove();
		$(".authorityActive").find(".viewFrmAuthority").append(frm);
	}
	
	//function hidden form add data
	function hiddenFrmAuthority(){
		$(".authorityActive").find(".btnAddAuthority").show();
		$(".authorityActive").find(".frmAuthority").remove();
		$(".authority").removeClass("authorityActive");
	}
	
	//view form add data
	$("#ppContent, .viewFrmAuthority").on("click", ".btnAddAuthority", function(){
		viewFrmAuthority(this);
	});
	
	//create data
	$("#ppContent, .authority").on("click", ".btnAuthorityCreate", function(){
		var name = $(".authorityActive").find("select[name=data]").val();
			name = $.trim(name);
		var type = $(".authorityActive").find("select[name=data] option:selected").attr("type");
			type = $.trim(type);
		var read = $(".authorityActive").find("input[name=read]:checked").val();
			read = parseInt($.trim(read));
		var create = $(".authorityActive").find("input[name=create]:checked").val();
			create = parseInt($.trim(create));
		var update = $(".authorityActive").find("input[name=update]:checked").val();
			update = parseInt($.trim(update));
		var del = $(".authorityActive").find("input[name=delete]:checked").val();
			del = parseInt($.trim(del));
		
		if(name=="" || type==""){
			alert("Value and type not allow empty");
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
		$(".authorityActive").find(".fieldAuthority").each(function(index, element) {
            arrData[index] = $(element).attr("name");
        });
		if(arrData.indexOf(name) != -1){
			alert('"' + name + '"' + ' already exists!');
			return false;
		}
		
		if(type=='groups'){
			$(".authorityActive").find(".authorityGroup").append(str);
		}else{
			$(".authorityActive").find(".authorityUsers").append(str);
		}
		hiddenFrmAuthority(this);
	});
	
	//active data
	$("#ppContent, .authority").on("click", ".fieldAuthority", function(){
		viewFrmAuthority(this);
		
		$(".fieldAuthority").removeClass("fieldAuthorityActive");
		$(this).addClass("fieldAuthorityActive");
		
		var name = $(".fieldAuthorityActive").attr("name");
		var read = $(".fieldAuthorityActive").find(".field:first").attr("value");
		var create = $(".fieldAuthorityActive").find(".field:eq(1)").attr("value");
		var update = $(".fieldAuthorityActive").find(".field:eq(2)").attr("value");
		var del = $(".fieldAuthorityActive").find(".field:eq(3)").attr("value");
		
		$(".authorityActive").find("select[name=data]").val(name);
		$(".authorityActive").find("input[name=read][value=" + read + "]").attr("checked", true);
		$(".authorityActive").find("input[name=create][value=" + create + "]").attr("checked", true);
		$(".authorityActive").find("input[name=update][value=" + update + "]").attr("checked", true);
		$(".authorityActive").find("input[name=delete][value=" + del + "]").attr("checked", true);
		
		$(".authorityActive").find(".btnAuthorityCreate").hide();
		$(".authorityActive").find(".btnAuthorityUpdate").show();
		$(".authorityActive").find(".btnAuthorityDelete").show();
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
		$(".authorityActive").find(".fieldAuthority").each(function(index, element) {
            arrData[index] = $(element).attr("name");
        });
		if(arrData.indexOf(name)!=-1 && name!=$(".fieldAuthorityActive").attr("name")){
			alert('"' + name + '"' + ' already exists!');
			return false;
		}
		
		if(type=='groups'){
			$(".authorityActive").find(".authorityGroup").append(str);
		}else{
			$(".authorityActive").find(".authorityUsers").append(str);
		}
		
		$(".fieldAuthorityActive").remove();
		
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