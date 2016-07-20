/*pp*/
function srollTop(){
	$("html, body").animate({ scrollTop: 0 }, 500);
}

function ppAutoSize(){
	$("#ppViewData").css({"width":"auto", "height":"auto"});
	
	var data_w = parseInt( $("#ppViewData").width() );
	var data_h = parseInt( $("#ppViewData").height() );
	var window_w = parseInt( $(window).width() );
	var window_h = parseInt( $(window).height() );
	
	if(window_w > data_w){
		var width = parseInt( (window_w - data_w) / 2 );
		$("#ppViewData").css("left", width);
	}else{
		$("#ppViewData").css({"left":"5%", "width":"80%"});
	}
	
	$("#ppViewData").css({"top":"0", "height":"auto"});
	if(window_h > data_h){
		var height = parseInt( (window_h - data_h - 50) / 2 );
		$("#ppViewData").css({"top":height, "height":"auto"});
	}else{
		$("#ppViewData").css({"top":"5%", "height":"81%"});
	}
}

function ppLoad(data){
	$("body").css("overflow", "hidden");
	$("#ppContent").html(data);
	$("#pp").show(150);
	ppAutoSize();
}

function ppClose(){
	$("body").css("overflow", "visible");
	$("#ppViewData").css({"top":"auto", "height":"auto"});
	$("#pp").hide();
	setTimeout(function(){
		$("#ppContent").html('');
	}, 100);
}

function ppCloseBG(){
	$("#ppBG").on("click", function(){
		ppClose();
	});
}
/*end pp*/

/*fixed width, height*/
function autoSizeLeftRight(){
	$("#wrapper, #left, #right").css("height", "auto");
	
	var win_h = parseInt($(window).height());
	var win_w = parseInt($(window).width());
	
	var left_h = parseInt($("#left").height());
	var left_w = parseInt($("#left").width());
	
	var right_h = parseInt($("#right").height());
	var right_w = parseInt(win_w - left_w - 1);
	
	//width auto
	if(right_w > 809){
		$("#wrapper").width(win_w);
		$("#right").width(right_w);
	}else{
		$("#wrapper").width(1000);
		$("#right").width(809);
	}
	
	//height auto
	if(win_h>=left_h+45 && win_h>=right_h+45){
		$("#left").height(win_h);
		$("#wrapper").height(win_h);
	}else if(right_h >= left_h){
		$("#left").height(right_h);
	}else{
		$("#right").height(left_h);
	}
}

function autoScrollFixed(){
	if ($(window).scrollTop() > 45) {
		var left = $("#left .typeAdmin").html();
		var right = $("#right .headerRight").html();
		var html = '<div class="typeAdmin">' + left + '</div>';
			html+= '<div class="header">' + right + '</div>';
		$("#headerFixed").html(html);
		$("#headerFixed").show(100);
	} else {
		$("#headerFixed").hide(100);
	}
}
/*end fixed width, height*/

/*check, get DATA*/
function checkValidDate(strDate){
	var regex = /^([1-9]\d{3}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)|(([2-9]\d)(0[48]|[2468][048]|[13579][26])|(([2468][048]|[3579][26])00))0229)$/;
    if(!(regex.test(strDate))) return false;
	
	return true;
}

function getDateTime(year, month, date, view){
	$( date + ", " + month + ", " + year ).on("change", function(){
		var valueDate = $(date).val();
		var valueMonth = $(month).val();
		var valueYear = $(year).val();
		var datetime = valueYear + valueMonth + valueDate;
		if( checkValidDate(datetime)==true ){
			datetime = valueYear + '-' + valueMonth + '-' + valueDate;
			$(view).val(datetime);
			return true;
		}else{
			$(view).val('');
			return false;
		}
	});
}

function formLoading(display, error, message){
	var width = $(".frm-loading").width();
	var height = $(".frm-loading").height();
	$(".frm-loading .loading").width(width);
	$(".frm-loading .loading").height(height);
	
	if(display==1) display='block'; else display='none';
	$(".frm-loading .loading").css("display", display);
	$(".frm-loading .errorGeneral").html(error);
}

function checkNumber(number){
	if(!isNaN(number)){
		return true;
	}else{
		return false;
	}
}

function checkPhone(number){
	//var re = /^[{0,+}][0-9]{9,13}$/;
	var re = /^[{0,+}][0-9]{9,18}$/;
	if(re.test(number)){
		return true;
	}else{
		return false;
	}
}

function checkEmail(email){
	//var re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	var re = /^[a-z0-9]+([\._-][a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/;
	if(re.test(email)){
		return true;
	}else{
		return false;
	}
}

function checkUser(string){
	var re = /^\w+([\.]?\w+){2,30}$/;
	if(re.test(string)){
		return true;
	}else{
		return false;
	}
}

function checkConfirm(string, tags){
	var strConfirm = $(tags).val();
	if(strConfirm==""){
		strConfirm = $(tags).text();
	}
	if(strConfirm==""){
		return false;
	}
	
	if(string==strConfirm){
		return true;
	}else{
		return false;
	}
}

function checkDataString(tags, condition, type){
	if(typeof type == "undefined"){
		type = "string";
	}
	
	var str = $.trim( $(tags).find(".value .field").val() );
	if( (str=="" || str==0) && condition==0){
		return str;
	}
	
	if(type == "number"){
		var check = checkNumber(str);
		if(str.length<condition || check==false){
			return false;
		}
	}else if(type == "phone"){
		var check = checkPhone(str);
		if(check==false){
			return false;
		}
	}else if(type == "email"){
		var check = checkEmail(str);
		if(check==false){
			return false;
		}
	}else if(type == "user"){
		var check = checkUser(str);
		if(check==false){
			return false;
		}
	}else if(type == "confirm"){
		var check = checkConfirm(str, condition);
		if(check==false){
			return false;
		}
	}else{
		if(str.length<condition){
			return false;
		}
	}
	
	return str;
}

function checkDataRadio(tags, condition){
	var str = $.trim( $(tags).find(".value .field:checked").val() );
	if( str.length < condition ){
		return false;
	}else if(str=="" && condition==0){
		return null;
	}
	return str;
}

function checkDataCheckBox(tags, condition){
	var str = "";
	var total = $(tags).find(".value .field:checked").length;
	if(total==1 && total>=condition){
		var str = $.trim( $(tags).find(".value .field:checked").val() );
	}else if(total>1 && total>=condition){
		var str = new Object();
		$(tags).find(".value .field:checked").each(function(index, element) {
			str[index] = $(element).val();
		});
	}else if(total==0 && condition==0){
		return null;
	}else{
		return false;
	}
	
	return str;
}

function checkDataCkeditor(tags, condition){
	var id = $.trim( $(tags).find(".value .field").attr("id") );
	var str = CKEDITOR.instances[id].getData();
	if( str.length < condition ){
		return false;
	}else if(str=="" && condition==0){
		return null;
	}
	return str;
}

function checkDataList(tags, condition){
	//check object
	if(typeof dataObject != 'object'){
		var dataObject = new Object();
	}
	
	var total = $(tags).children(".field").length;
	if(total>0 && total>=condition){
		var errors = new Object();
		$(tags).children(".field").each(function(index, element) {
			//check field value
			if(typeof $(element).attr("key") != "undefined"){
				var key = $(element).attr("key");
				var value = $(element).attr("value");
				
				dataObject[key] = value;
			}else if(typeof $(element).attr("type")!="undefined" && $(element).attr("type")=="datalist"){
				var name = $(element).attr("name");
				
				var condition = 0;
				if(typeof $(element).attr("condition")!="undefined"){
					condition = $(element).attr("condition");
				}
				
				var values = $(element).children(".values");
				
				var data = checkDataList(values, condition);
				if(data == false){
					errors[name] = false;
					$(element).children(".values").children(".error").show(100);
				}else{
					$(element).children(".values").children(".error").hide(100);
				}
				
				dataObject[name] = data;
			}else {
				return false;
			}
		});
		
		//export error
		var error = 0;
		for(var key in errors){
			error++;
		}
		
		if(error==0){
			return dataObject;
		}else{
			console.log(errors);
			return false;
		}
	}else if(total==0 && condition==0){
		return null;
	}else{
		return false;
	}
}

//Get DATA Values
function checkGetData(tags, condition){
	//check object
	if(typeof dataObject != "object"){
		var dataObject = new Object();
	}
	//check var condition
	if(typeof condition == "undefined"){
		var condition = 0;
	}
	
	//check error
	$(tags).children(".error").hide(100);
	var errors = new Object();
	
	var total = $(tags).children(".field").length;
	if(total>0 && total>=condition){
		$(tags).children(".field").each(function(index, element) {
			//check exist type
			if(typeof $(element).attr("type")!="undefined" && $(element).attr("type")!="noaction"){
				var type = $(element).attr("type");
				
				//get info
				var data = new Object();
				
				if(typeof $(element).attr("name") != "undefined"){
					var name = $(element).attr("name");
				}else{
					return false;
				}
				
				var check = "";
				if(typeof $(element).attr("check") != "undefined"){
					check = $(element).attr("check");
				}
				
				if(typeof $(element).attr("condition") != "undefined"){
					condition = $(element).attr("condition");
				}else{
					condition = 0;
				}
				
				//check values data
				var values = $(element).children(".values");
				
				//check type string
				if(type == "radio"){
					data = checkDataRadio(values, condition);
				}else if(type == "checkbox"){
					data = checkDataCheckBox(values, condition);
				}else if(type == "textckeditor"){
					data = checkDataCkeditor(values, condition);
				}else if(type == "datalist"){ //check type dataList
					data = checkDataList(values, condition);
				}else if(type == "group"){ //check type group
					data = checkGetData(values, condition);
				}else{
					data = checkDataString(values, condition, check);
				}
				
				//check error
				if(typeof data=='boolean' && data==false){
					errors[name] = false;
					$(element).children(".values").children(".error").show(100);
				}else{
					$(element).children(".values").children(".error").hide(100);
				}
				
				dataObject[name] = data;
			}else if(typeof $(element).attr("value") != "undefined"){
				var name = $(element).html();
				var value = $(element).attr("value");
				
				var data = new Object();
					data.name = name;
					data.value = value;
				
				dataObject[index] = data;
			}else if($(element).attr("type")=="noaction"){
				
			}else{
				return false;
			}
		});
		
		//export error
		var error = 0;
		for(var key in errors){
			error++;
		}
		
		if(error==0){
			return dataObject;
		}else{
			console.log(errors);
			return false;
		}
	}else if(total==0 && condition==0){
		return null;
	}else{
		$(tags).children(".error").show(100);
		return false;
	}
}

function convertToJson(data){
	try{
		data = $.parseJSON(data);
		return data;
	}catch(e){
		console.log(data);
		return false;
	}
}

function actionUpload(){
	if( $(".iAC-Collection input[name=_id]").length ){
		var id = $(".iAC-Collection input[name=_id]").val();
		if(id=="" || id=="0"){
			return false;
		}
		
		var name = $(".iAC-Collection input[name=name]").val();
		
		var files = new Object();
			files.id = id;
			files.name = name;
			files.data = new Object();
		
		var count = 0;
		$("#uploads-console .list-file .item").each(function(index, element) {
			count++;
            var name = $(element).attr("_name");
            var file = $(element).attr("_file");
			var data = new Object();
				data.name = name;
				data.file = file;
				
			files.data[index] = data;
        });
		
		if(count==0) return false;
		
		$.ajax({ 	
			url     : 'ajax',
			type    : 'post',
			data    : {_request:'actionUpload', files:files},
			cache   : false,
			success : function(data){
				data = convertToJson(data);
				if(data==false){
					console.log("ERROR: Action upload");
					return false;
				}
				
				for(var i in data){
					var row = data[i];
					if(row.result!=false){
						var id = row.file;
						var url = '/public/images/' + row.file + '.' + row.extension;
						$("#" + id).attr("_url", url);
					}else{
						console.log(row.message);
					}
				}
			}
		});
	}
}

function reloadCKeditor(){
	var editor = CKEDITOR.instances.content_ck;
	
	var content = editor.getData();
		content = content.replace(/\/public\/temp\//g, '/public/images/');
		
	editor.setData(content);
	setTimeout(function(){
		editor.setData(content);
	}, 200);
}

//Submit fields
function ajaxSubmitFields(){
	if( $("#uploads-console").length ){
		reloadCKeditor();
	}
	
	var tags = $(".iAC-Collection-Active");
	var fields = checkGetData(tags);
	
	if(fields==false) {
		srollTop();
		return false;
	}
	
	$(tags).find(".field").attr("disabled", true);
	
	$("#saveMessage").remove();
	var str = '<p>Processing..</p>';
	ppLoad(str);
	
	fields._collection = $(".iAC-Collection-Active").attr("name");
	fields._action = $(".iAC-Collection-Active").attr("action");
	
	$.ajax({ 	
		url     : 'ajax',
		type    : 'post',
		data    : fields,
		cache   : false,
		success : function(data){
			$(tags).find(".field").attr("disabled", false);
			
			data = convertToJson(data);
			if(data==false){
				var str = '<p class="error">ERROR: Server</p>';
				ppLoad(str);
				return false;
			}else if(data.result==false){
				var str = '<p class="error">' + data.message + '</p>';
				ppLoad(str);
				console.log(data);
				return false;
			}
			
			console.log(data);
			ppClose();
			
			var message = '<div id="saveMessage" class="bgGreen corner5" style="width:15%; color:#FFF; text-align:center; position:fixed; top:45px; left:40%; padding:8px 0; z-index:2;"><p>Success!</p></div>';
			$("body").append(message);
			setTimeout(function(){
				$("#saveMessage").remove();
			}, 3000);
			
			if(typeof data.data._id != "undefined"){
				var _id = data.data._id;
				
				$("input[name=_id]").val(_id);
				$(".iAC-Collection-Active").attr("action", "update");
				
				var hostname = $(location).attr('hostname');
				var pathname = $(location).attr('pathname');
				window.history.pushState(null, 'Title', 'http://' + hostname + pathname + '?_id=' + _id);
			}
			
			if( $("#uploads-console").length ){
				actionUpload();
			}
		}
	});
}

function btnAjaxSubmit(){
	$("body").on("click", ".iAC-Submit", function(){
		$(".iAC-Collection").removeClass("iAC-Collection-Active");
		$(this).parents(".iAC-Collection").addClass("iAC-Collection-Active");
		
		ajaxSubmitFields();
	});
	
	$("body").on("click", ".btnSubmitSave", function(){
		$(".iAC-Collection").removeClass("iAC-Collection-Active");
		$("#iAC-Collection").addClass("iAC-Collection-Active");
		
		ajaxSubmitFields();
	});
}
/*end check, get DATA*/

/*delete*/
(function(){
	$(".adTable .row .delete").click(function(){
		$(".adTable .row").removeClass("rowActive");
		$(this).parents(".row").addClass("rowActive");
		
		var id = $(this).parents(".row").attr("_id");
		var name = $(this).parents(".row").find(".name").html();
		if( confirm('Delete "' + name + '"?') == false ){
			return false;
		}
		
		var fields = new Object();
		fields._action = "delete";
		fields._id = id;
		
		$.ajax({ 	
			url     : 'ajax',
			type    : 'post',
			data    : fields,
			cache   : false,
			success : function(data){
				data = convertToJson(data);
				if(data==false){
					var str = '<p class="error">ERROR: Server</p>';
					ppLoad(str);
					return false;
				}else if(data.result==false){
					var str = '<p class="error">' + data.message + '</p>';
					ppLoad(str);
					console.log(data);
					return false;
				}
				
				console.log(data);
				$(".adTable .rowActive").remove();
			}
		});
	});
})();
/*end delete*/

/*auto name, alias, title, tags*/
function changeAlias(str, replace){
	var alias = str;
	alias = alias.toLowerCase();
	alias = alias.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
	alias = alias.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
	alias = alias.replace(/ì|í|ị|ỉ|ĩ/g,"i");
	alias = alias.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");
	alias = alias.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
	alias = alias.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
	alias = alias.replace(/đ/g,"d");
	alias = alias.replace(/!|®|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|–|_|-/g, replace);
	alias = alias.replace(/\\|\$|\||\{|\}|\`/g, replace);
	/* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */
	alias = alias.replace(/-+-/g, replace); //thay thế 2 - thành 1- 
	alias = alias.replace(/ + /g, replace); //thay thế 2 - thành 1- 
	alias = alias.replace(/^\-+|\-+$/g,""); //cắt bỏ ký tự - ở đầu và cuối chuỗi
	alias = alias.replace(/^\ +|\ +$/g,""); //cắt bỏ ký tự - ở đầu và cuối chuỗi
	return alias;
}

function removeSpecialCharacters(str, replace){
	var alias = str;
	alias = alias.toLowerCase();
	alias = alias.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_|-/g, replace);
	alias = alias.replace(/\\|\$|\||\{|\}|\`/g, replace);
	/* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */
	alias = alias.replace(/-+-/g, replace); //thay thế 2 - thành 1- 
	alias = alias.replace(/ + /g, replace); //thay thế 2 - thành 1- 
	alias = alias.replace(/^\-+|\-+$/g,""); //cắt bỏ ký tự - ở đầu và cuối chuỗi
	alias = alias.replace(/^\ +|\ +$/g,""); //cắt bỏ ký tự - ở đầu và cuối chuỗi
	return alias;
}

function checkAlias(){
	var alias = $.trim( $("input[name=alias]").val() );
	$.ajax({
		url: 'ajax',
		type:'POST',
		data:{_request:checkAlias, alias:alias},
		cache:false,
		success: function(data) {
			console.log(data);
		}
	});
}

function aliasAuto(dest, source){
	var alias = $(dest).val();
	if(alias==''){
		var alias = $.trim( $(source).val() );
			alias = changeAlias(alias, '-');
		$(dest).val(alias);
	}
}

function titleAuto(dest, source){
	var title = $(dest).val();
	if(title==''){
		var name = $.trim( $(source).val() );
		$(dest).val(name);
	}
}

function tagsAuto(dest, source){
	var tags = $(dest).val();
	if(tags==''){
		var name = removeSpecialCharacters( $.trim($(source).val()), ' ' );
		$(dest).val(name);
	}
}

$("input[name=name]").blur(function(){
	aliasAuto("input[name=alias]", "input[name=name]");
	titleAuto("input[name=title]", "input[name=name]");
	tagsAuto("input[name=tags]", "input[name=name]");
});

$("input[name=alias]").blur(function(){
	aliasAuto();
});

$("input[name=tags]").dblclick(function(){ 
	var tags = $(this).val();
	if(tags==''){
		tags = $("input[name=name]").val();
	}
	tags = removeSpecialCharacters(tags, ' ');
	
	var str = tags + ',' + changeAlias(tags, ' ');
	$(this).val(str);
});
/*end auto name, alias, title, tags*/

$(document).ready(function(e) {
	/*auto load view width, height*/
	autoSizeLeftRight();
	$(window).bind("resize", function(){
		autoSizeLeftRight();
		ppAutoSize();
	});
	
	autoScrollFixed();
	$(window).bind('scroll', function(){
		autoScrollFixed();
	});
	/*end auto load view width, height*/
	
	/*pp*/
	$("body").on("click", ".ppClose", function(){
		ppClose();
	});
	
	$("body").on("click", ".ppCloseReload", function(){
		window.location.reload();
	});
	/*end pp*/
	
	/*click and hover row*/
	$(".adTable").on("click", ".row", function(){
		$(".adTable .row").removeClass("active");
		$(this).addClass("active");
	});
	
	$(".adTable").on("mouseover", ".row", function(){
		$(this).find(".action span").show();
	});
	
	$(".adTable").on("mouseout", ".row", function(){
		$(this).find(".action span").hide();
	});
	/*end click and hover row*/
});