<div class="box">
	<ul class="iAC-Collection frmRegister" name="contact" action="create" style="width:250px">
        <li name="email" type="email" check="email" condition="1" class="field">
            <ul class="values valuesFull">
                <li class="field"><p class="value"><input type="email" name="email" value="" class="field input" maxlength="60" placeholder="Nhập email" /></p></li>
                <p class="error hidden">Email chưa đúng</p>
            </ul>
            <p class="clear1"></p>
        </li>
        
        <li name="password" type="password" check="string" condition="6" class="field">
            <ul class="values valuesFull">
                <li class="field"><p class="value"><input type="password" name="password" value="" class="field input" maxlength="60" placeholder="Nhập mật khẩu" /></p></li>
                <p class="error hidden">Mật khẩu phải hơn 6 ký tự</p>
            </ul>
            <p class="clear1"></p>
        </li>
        
        <li name="password_confirm" type="password" check="confirm" condition="input[name=password]" class="field">
            <ul class="values valuesFull">
                <li class="field"><p class="value"><input type="password" name="password_confirm" value="" class="field input" maxlength="60" placeholder="Nhập lại mật khẩu" /></p></li>
                <p class="error hidden">Mật khẩu lại mật khẩu chưa đúng</p>
            </ul>
            <p class="clear1"></p>
        </li>
        
        <li name="datetime" type="datetime" check="datetime" condition="1" class="field" style="display:none;">
            <ul class="values">
                <li class="field"><p class="value"><input type="datetime" name="datetime" value="<?php echo date(_DATETIME_);?>" class="field" /></p></li>
            </ul>
        </li>
        
        <li class="field" name="submit" type="noaction">
            <ul class="values">
                <li class="field">
                    <input type="button" name="btnRegister" value="Đăng ký" class="btnRegister btnMedium bgBlue corner5" />
                </li>
            </ul>
        </li>
    </ul>
    <p class="clear10"></p>
    <p style="color:#999; font-size:120%; text-align:center;">--- hoặc ---</p>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#pp").on("click", ".btnRegister", function(){
		var fields = checkGetData( $(".frmRegister") );
		if(fields==false){
			return false;
		}
		
	});
});
</script>