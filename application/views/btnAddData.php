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
        <p class="width65"><i>Key:</i> <input type="text" name="key" value="" class="input" /></p>
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
	//function view form add data
	function viewFrmAddData(tags){
		var frm = $("#frmAddData").html();
		$(tags).parents(".addData").children(".viewFrmAddData").children(".btnAddData").hide();
		$(tags).parents(".addData").children(".viewFrmAddData").children(".frmAddData").remove();
		$(tags).parents(".addData").children(".viewFrmAddData").append(frm);
	}
	
	//function hidden form add data
	function hiddenFrmAddData(tags){
		$(tags).parents(".addData").children(".viewFrmAddData").children(".btnAddData").show();
		$(tags).parents(".addData").children(".viewFrmAddData").children(".frmAddData").remove();
	}
	
	//view form add data
	$("#ppContent, .addData").on("click", ".btnAddData", function(){
		viewFrmAddData(this);
	});
	
	//create data
	$("#ppContent, .addData").on("click", ".btnDataCreate", function(){
		var key = "";
		if( $(this).parents(".frmAddData").find("input[name=key]").length ){
			key = $(this).parents(".frmAddData").find("input[name=key]").val();
			key = $.trim(key);
		}else if( $(this).parents(".frmAddData").find("select[name=key]").length ){
			key = $(this).parents(".frmAddData").find("select[name=key]").val();
			key = $.trim(key);
		}
		
		var value = "";
		if( $(this).parents(".frmAddData").find("input[name=value]").length ){
			value = $(this).parents(".frmAddData").find("input[name=value]").val();
			value = $.trim(value);
		}else if( $(this).parents(".frmAddData").find("select[name=value]").length ){
			value = $(this).parents(".frmAddData").find("select[name=value]").val();
			value = $.trim(value);
		}
		
		if(key=="" || value==""){
			alert("Key and value not allow empty");
			return false;
		}
		
		var arrData = new Array();
		$(this).parents(".addData").children(".listAddData").children(".fieldAddData").each(function(index, element) {
            arrData[index] = $(element).attr("key");
        });
		if(arrData.indexOf(key) != -1){
			alert('"' + key + '"' + ' already exists!');
			return false;
		}
		
		var str = '<li class="field fieldAddData" key="' + key + '" value="' + value + '">' + key + ' <i>(' + value + ')</i></li>';
		$(this).parents(".addData").children(".listAddData").append(str);
		
		hiddenFrmAddData(this);
	});
	
	//active data
	$("#ppContent, .addData").on("click", ".fieldAddData", function(){
		viewFrmAddData(this);
		
		$(".fieldAddData").removeClass("fieldAddDataActive");
		$(this).addClass("fieldAddDataActive");
		
		var key = $(this).attr("key");
		var value = $(this).attr("value");
		
		setTimeout(function(){
			if( $(".fieldAddDataActive").parents(".addData").find("input[name=key]").length ){
				$(".fieldAddDataActive").parents(".addData").find("input[name=key]").val(key);
			}else if( $(".fieldAddDataActive").parents(".addData").find("select[name=key]").length ){
				$(".fieldAddDataActive").parents(".addData").find("select[name=key]").val(key);
			}
			
			if( $(".fieldAddDataActive").parents(".addData").find("input[name=value]").length ){
				$(".fieldAddDataActive").parents(".addData").find("input[name=value]").val(value);
			}else if( $(".fieldAddDataActive").parents(".addData").find("select[name=value]").length ){
				$(".fieldAddDataActive").parents(".addData").find("select[name=value]").val(value);
			}
		}, 100);
		
		$(this).parents(".addData").children(".viewFrmAddData").find(".btnDataCreate").hide();
		$(this).parents(".addData").children(".viewFrmAddData").find(".btnDataUpdate").show();
		$(this).parents(".addData").children(".viewFrmAddData").find(".btnDataDelete").show();
	});
	
	
	//update data
	$("#ppContent, .addData").on("click", ".btnDataUpdate", function(){
		var key = "";
		if( $(this).parents(".frmAddData").find("input[name=key]").length ){
			key = $(this).parents(".frmAddData").find("input[name=key]").val();
			key = $.trim(key);
		}else if( $(this).parents(".frmAddData").find("select[name=key]").length ){
			key = $(this).parents(".frmAddData").find("select[name=key]").val();
			key = $.trim(key);
		}
		
		var value = "";
		if( $(this).parents(".frmAddData").find("input[name=value]").length ){
			value = $(this).parents(".frmAddData").find("input[name=value]").val();
			value = $.trim(value);
		}else if( $(this).parents(".frmAddData").find("select[name=value]").length ){
			value = $(this).parents(".frmAddData").find("select[name=value]").val();
			value = $.trim(value);
		}
		
		if(key=="" || value==""){
			alert("Key and value not allow empty");
			return false;
		}
		
		var arrData = new Array();
		$(this).parents(".addData").children(".listAddData").children(".fieldAddData").each(function(index, element) {
            arrData[index] = $(element).attr("key");
        });
		if( arrData.indexOf(key)!=-1 && key!=$(".fieldAddDataActive").attr("key") ){
			alert('"' + key + '"' + ' already exists!');
			return false;
		}
		
		var label = key + ' <i>(' + value + ')</i>';
		$(".fieldAddDataActive").attr("key", key);
		$(".fieldAddDataActive").attr("value", value);
		$(".fieldAddDataActive").html(label);
		
		hiddenFrmAddData(this);
	});
	
	//delete data
	$("#ppContent, .addData").on("click", ".btnDataDelete", function(){
		$(".fieldAddDataActive").remove();
		hiddenFrmAddData(this);
	});
	
	//cancel data
	$("#ppContent, .addData").on("click", ".btnDataCancel", function(){
		hiddenFrmAddData(this);
	});
});
</script>