<div class="box">
	<ul class="iAC-Collection frm-register" style="display:none;">
    	<p class="register-error" style="color:#F00;"></p>
        <p class="clear10"></p>
        
        <li name="email" type="email" check="email" condition="1" class="field">
            <ul class="values valuesFull">
                <li class="field"><p class="value"><input type="email" name="email" value="" class="field input enter-register" maxlength="60" placeholder="Nhập email" /></p></li>
                <p class="error hidden">Email chưa đúng</p>
            </ul>
            <p class="clear1"></p>
        </li>
        
        <li name="password" type="password" check="string" condition="6" class="field">
            <ul class="values valuesFull">
                <li class="field"><p class="value"><input type="password" name="password" value="" class="field input enter-register" maxlength="60" placeholder="Nhập mật khẩu" /></p></li>
                <p class="error hidden">Mật khẩu phải hơn 6 ký tự</p>
            </ul>
            <p class="clear1"></p>
        </li>
        
        <li name="password_confirm" type="password" check="confirm" condition="input[name=password]" class="field">
            <ul class="values valuesFull">
                <li class="field"><p class="value"><input type="password" name="password_confirm" value="" class="field input enter-register" maxlength="60" placeholder="Nhập lại mật khẩu" /></p></li>
                <p class="error hidden">Mật khẩu lại mật khẩu chưa đúng</p>
            </ul>
            <p class="clear1"></p>
        </li>
        
        <li class="field" name="submit" type="noaction">
            <ul class="values valuesFull">
                <li class="field">
                    <input type="button" name="btn-register" value="Đăng ký" class="btn-register btnMedium bgBlue corner5" />
                    <a href="javascript:;" style="margin-left:20px" class="view-frm-register" type="login">Đăng nhập</a>
                </li>
            </ul>
        </li>
    </ul>
    
    <ul class="iAC-Collection frm-login" style="display:none;">
    	<p class="login-error" style="color:#F00;"></p>
        <p class="clear10"></p>
        
        <li name="email" type="email" check="email" condition="1" class="field">
            <ul class="values valuesFull">
                <li class="field"><p class="value"><input type="email" name="email" value="" class="field input enter-login" maxlength="60" placeholder="Nhập email" /></p></li>
                <p class="error hidden">Email chưa đúng</p>
            </ul>
            <p class="clear1"></p>
        </li>
        
        <li name="password" type="password" check="string" condition="6" class="field">
            <ul class="values valuesFull">
                <li class="field"><p class="value"><input type="password" name="password" value="" class="field input enter-login" maxlength="60" placeholder="Nhập mật khẩu" /></p></li>
                <p class="error hidden">Mật khẩu chưa đúng</p>
            </ul>
            <p class="clear1"></p>
        </li>
        
        <li class="field" name="submit" type="noaction">
            <ul class="values valuesFull">
                <li class="field">
                    <input type="button" name="btn-login" value="Đăng nhập" class="btn-login btnMedium bgGreen corner5" />
                    <a href="javascript:;" style="margin-left:20px" class="view-frm-register" type="register">Đăng ký</a>
                </li>
            </ul>
        </li>
    </ul>
    <p class="clear10"></p>
    <p style="color:#999; font-size:120%; text-align:center;">--- hoặc ---</p>
</div>

<script type="text/javascript">
$(document).ready(function() {
	function register(){
		var fields = checkGetData( $("#pp .frm-register") );
		if(fields==false){
			return false;
		}
		
		$("#pp .register-error").html("");
		$("#pp .frm-register .field").attr("disabled", true);
		
		fields._request = 'users';
		fields._action = 'register';
		
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
					$("#pp .register-error").html(data.message);
					$("#pp .frm-register .field").attr("disabled", false);
					return false;
				}
				
				window.location.reload();
			}
		});
	}
	
    $("#pp").on("click", ".btn-register", function(){
		register();
	});
	$("#pp").on("keydown", ".enter-register", function(e){
		if(e.keyCode==13){
			register();
		}
	});
	
	function login(){
		var fields = checkGetData( $("#pp .frm-login") );
		if(fields==false){
			return false;
		}
		
		$("#pp .login-error").html("");
		$("#pp .frm-login .field").attr("disabled", true);
		
		fields._request = 'users';
		fields._action = 'login';
		
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
					$("#pp .login-error").html(data.message);
					$("#pp .frm-login .field").attr("disabled", false);
					return false;
				}
				
				window.location.reload();
			}
		});
	}
	
	$("#pp").on("click", ".btn-login", function(){
		login();
	});
	$("#pp").on("keydown", ".enter-login", function(e){
		if(e.keyCode==13){
			login();
		}
	});
});
</script>