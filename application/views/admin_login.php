<!DOCTYPE html>
<html>
<head>
<base href="<?php echo _DOMAIN_;?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Quản trị website</title>
<meta name="robots" content="nofollow" />
<link type="icon/x-icon" href="public/themes/favicon.ico" rel="shortcut icon" />
<link rel="stylesheet" type="text/css" href="public/themes/admin/global.css">
<link rel="stylesheet" type="text/css" href="public/themes/admin/style.css">
<script type="text/javascript" src="public/js/jsJquery.js"></script>
<script type="text/javascript" src="public/js/jsGlobal.js"></script>
</head>
<body>

<div id="loginPage">
    <div class="frmLoginPage">
        <h1 class="h1">
            <span class="iconLogin">
            <span class="i">i</span>
            <span class="a">A</span>
            <span class="c">C</span>
            </span>
            Webmaster
        </h1>
        <h2 class="h2">© Copyright</h2>
        <div class="frm">
        	<h3 class="title icon">Please Enter Your Information</h3>
        	<ul class="iAC-Collection" name="setting" type="submit" action="read">
                <li class="field" name="username" type="string" check="user" condition="3">
                    <ul class="values valuesFull">
                    	<li class="field">
                    		<p class="value"><input type="text" name="username" class="field input icon" placeholder="Username" style="background-position: 305px -43px" /></p>
                    	</li>
                    	<p class="error hidden">Username chưa đúng</p>
                    </ul>
                    <p class="clear10"></p>
                </li>
                <li class="field" name="password" type="string" check="string" condition="6">
                    <ul class="values valuesFull">
                    	<li class="field">
                    		<p class="value"><input type="password" name="password" class="field input icon" placeholder="Password" style="background-position: 305px -93px" /></p>
                    	</li>
                    	<p class="error hidden">Password chưa đúng</p>
                    </ul>
                    <p class="clear10"></p>
                </li>
                <li class="field" name="submit" type="noaction">
                    <ul class="valuesFull">
                        <li class="field">
                        	<span class="remember"><input type="checkbox" name="remenber" value="1" /> Remember Me</span>
                            <input type="button" name="iAC-Submit" value="Submit" class="field iAC-Submit btnMedium bgBlue floatRight" />
                        </li>
                        <p class="clear1"></p>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<div id="pp">
	<div id="ppViewData">
    	<div class="ppClose ppCloseStyle">x</div>
        <div class="clear10"></div>
    	<div id="ppContent"></div>
    </div>
    <div id="ppBG"></div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	function login(){
		var tags = $(".iAC-Collection");
		var fields = checkGetData(tags);
		if(fields==false) {
			srollTop();
			return false;
		}
		
		$(tags).find(".field").attr("disabled", true);
		
		fields._request = 'users';
		fields._action = 'login';
		
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
					return false;
				}
				
				if(!data.url){
					window.location.reload();
				}else{
					window.location = data.url;
				}
			}
		});
	}
	
	$(".iAC-Submit").click(function(){
		login();
	});
	
	$(".field").keydown(function(e){
		if(e.keyCode==13){
			login();
		}
	});
});
</script>

</body>
</html>