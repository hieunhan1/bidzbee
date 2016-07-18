<div id="uploads-console">
	<div class="drop-zone" id="drop-zone">
    	<h4>Drop files here to upload</h4>
        <div class="form-upload">
            <form action="ajax" method="post" enctype="multipart/form-data">
                <input type="file" name="files[]" id="standard-upload-files" multiple="multiple" />
                <input type="submit" value="Upload" class="btnMedium bgRed corner5" id="standard-upload" />
            </form>
        </div>
    </div>
    <div class="list-file">
        <!--<div class="item active">
        	<p class="avarta">chọn làm<br />ảnh đại diện</p>
            <p class="img imgWidth"><img src="public/images/iphone.jpg" alt="" /></p>
            <p class="copy"><a href="javascript:;">Copy link</a></p>
            <p class="delete"><a href="javascript:;">Delete</a></p>
        </div>-->
    </div>
</div>

<style type="text/css">
#standard-upload-files{
	width: 65%;
	max-width: 220px;
}

#uploads-console{
	width: 98%;
	height: 120px;
	position: fixed;
	bottom: 0;
	right: 0;
	margin: auto;
	padding: 1%;
	z-index: 2;
	background-color: rgba(255,255,255,0.8);
	border-top: solid 1px #999;
}
#uploads-console .drop-zone{
	width: 30%;
	max-width: 350px;
	height: 100px;
	line-height: 50px;
	float: left;
	color: #999;
	text-align: center;
	padding: 10px 0;
	border: 2px dashed #999;
}
#uploads-console .drop-zone h4{
	font-size: 130%;
}
#uploads-console .drag-over{
	border-color: #333 !important;
	color: #333;
}
#uploads-console .list-file{
	width: 67%;
	height: 110px;
	overflow: auto;
	line-height: 20px;
	float: right;
}
#uploads-console .list-file .item{
	width: 100px;
	height: 90px;
	float: left;
	font-size: 90%;
	font-weight: bold;
	margin: 0 5px 5px 0;
	padding: 5px;
	background-color: #FFF;
	border: solid 2px #CCC;
}
#uploads-console .list-file .item:hover .avarta{
	display: block;
}
#uploads-console .list-file .active{
	border: solid 2px #d15b47;
}
#uploads-console .list-file .item .avarta{
	display: none;
	width: 110px;
	height: 43px;
	text-align: center;
	color: #555;
	font-size: 110%;
	text-transform: uppercase;
	position: absolute;
	z-index: 1;
	margin:-5px 0 0 -5px;
	padding: 15px 0;
	background-color: rgba(255,255,255,0.6);
	cursor: pointer;
}
#uploads-console .list-file .item .img{
	width: 100%;
	height: 68px;
	margin-bottom: 5px;
}
#uploads-console .list-file .item .copy{
	width: auto;
	float: left;
}
#uploads-console .list-file .item .delete{
	width: auto;
	float: right;
}
#uploads-console .list-file .item .delete a{
	color: #d15b47;
}
#uploads-console .list-file .item .bar{
	width: 100%;
	color: #FFF;
	border: 1px solid #09F;
	border-radius: 20px;
	overflow: hidden;
	margin-top: 5px;
}
#uploads-console .list-file .item .bar-fill{
	display: block;
	width: 100%;
	height: 20px;
	line-height: 20px;
	background-color: #09F;
	-webkit-transform: width 0.2s ease;
	transition: width 0.2s ease;
}
#uploads-console .list-file .item .bar-text{
	margin-left: 10px;
}
</style>

<script type="text/javascript">
$(document).ready(function() {
	$("#uploads-console").on("click", ".item", function(){
		$("#uploads-console .item").removeClass("active");
		$(this).addClass("active");
	});
	
	(function(){
		var dropzone = document.getElementById("drop-zone");
		
		var displayUploads = function(data){
			$("#standard-upload-files").val("");
			
			for(var i in data){
				if(data[i].data){
					$("#uploads-console .list-file").append(data[i].data);
				}
			}
			
			if( !$("#uploads-console .active").length ){
				$("#uploads-console .item:first").addClass("active");
			}
		}
		
		var upload = function(files){
			var formData = new FormData(),
				xhr = new XMLHttpRequest(),
				x;
			
			for(x=0; x<files.length; x=x+1){
				formData.append("files[]", files[x]);
			}
			
			xhr.onload = function(){
				var data = convertToJson(this.responseText);
				displayUploads(data);
			}
			
			xhr.open("post", "ajax");
			xhr.send(formData);
		}
		
		dropzone.ondrop= function(e){
			e.preventDefault();
			this.className = "drop-zone";
			upload(e.dataTransfer.files);
		};
		
		document.getElementById('standard-upload').addEventListener('click', function(e){
			var standardUploadFiles = document.getElementById('standard-upload-files').files;
			if(standardUploadFiles.length==0){
				e.preventDefault();
				return false;
			}
			e.preventDefault();
			upload(standardUploadFiles);
		});
		
		dropzone.ondragover = function(){
			this.className = "drop-zone drag-over";
			return false;
		};
		
		dropzone.ondragleave = function(){
			this.className = "drop-zone";
			return false;
		};
		
	})();
	
	/*copy link image*/
	function copySuccess(){
		$(".js-message").show(100);
		$(".js-data").hide(100);
		$(".js-btn").hide(100);
		setTimeout(function(){
			$(".js-message").hide(100);
			$(".js-data").show(100);
			$(".js-btn").show(100);
			$("#copyData").hide(100);
		}, 1000);
		return true;
	}
	function copyToClipboard(element){
		var $temp = $('<input type="text" name="copy" />');
		$("body").append($temp);
		$temp.val($(element).text()).select();
		document.execCommand("copy");
		$temp.remove();
		copySuccess();
		return true;
	}
	$("#uploads-console").on("click", ".copy", function(){
		var url = $(this).parent(".item").attr("_url");
		
		alert(url);
		return true;
		
		$('.js-copydata').html(data.img_url + data.img);
		$("#copyData").show(100);
		
		return true;
	});
	$(".js-copybtn").live("click", function(){
		copyToClipboard('.js-copydata');
	});
	$(".js-copycancel").live("click", function(){
		$("#copyData").hide(100);
		return true;
	});
	/*end copy link image*/
});
</script>