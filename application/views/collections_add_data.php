<div id="frmAddData" class="hidden">
	<div class="frmAddData">
        <p class="clear5"></p>
        <p class="width50"><i>Field name:</i> <input type="text" name="key" value="" class="input" /></p>
        <p class="width50">
            <i>Type:</i>
            <?php
            $type = array(
				'text' => 'Text',
				'number' => 'Number',
				'date' => 'Date',
				'bool' => 'Boolean',
				'pass' => 'Password',
				'textCKeditor' => 'Text CKeditor',
				'auto' => 'Auto',
			);
			?>
            <select name="value" class="select">
            	<?php
                foreach($type as $name=>$label){
					echo '<option value="'.$name.'">'.$label.'</option>';
				}
				?>
            </select>
        </p>
        <p class="clear5"></p>
        <p class="width50">
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
		
		ppAutoSize();
	}
	
	//function hidden form add data
	function hiddenFrmAddData(tags){
		$(tags).parents(".addData").children(".viewFrmAddData").children(".btnAddData").show();
		$(tags).parents(".addData").children(".viewFrmAddData").children(".frmAddData").remove();
		
		ppAutoSize();
	}
	
	//view form add data
	$("#ppContent, .addData").on("click", ".btnAddData", function(){
		viewFrmAddData(this);
	});
	
	//create data
	$("#ppContent, .addData").on("click", ".btnDataCreate", function(){
		var key = $(this).parents(".frmAddData").find("input[name=key]").val();
			key = $.trim(key);
		var value = $(this).parents(".frmAddData").find("select[name=value]").val();
			value = $.trim(value);
		
		if(key=="" || value==""){
			alert("Name not allow empty");
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
		
		var str = '<li class="field fieldAddData" key="' + key + '" value="' + value + '">' + key + ' <i>('+ value + ')</i></li>';
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
		
		$(this).parents(".addData").children(".viewFrmAddData").find("input[name=key]").val(key);
		$(this).parents(".addData").children(".viewFrmAddData").find("select[name=value]").val(value);
		
		$(this).parents(".addData").children(".viewFrmAddData").find(".btnDataCreate").hide();
		$(this).parents(".addData").children(".viewFrmAddData").find(".btnDataUpdate").show();
		$(this).parents(".addData").children(".viewFrmAddData").find(".btnDataDelete").show();
	});
	
	
	//update data
	$("#ppContent, .addData").on("click", ".btnDataUpdate", function(){
		var key = $(this).parents(".frmAddData").find("input[name=key]").val();
		var value = $(this).parents(".frmAddData").find("select[name=value]").val();
		
		if(key=="" || value==""){
			alert("Name not allow empty");
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