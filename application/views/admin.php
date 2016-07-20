<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="http://<?php echo $_SERVER['HTTP_HOST'];?>/" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Quản trị website</title>
<meta name="robots" content="nofollow" />
<link type="icon/x-icon" href="public/themes/favicon.ico" rel="shortcut icon" />
<link type="text/css" href="public/themes/admin/global.css" rel="stylesheet" />
<link type="text/css" href="public/themes/admin/style.css" rel="stylesheet" />
<link type="text/css" href="public/js/datetimepicker/jquery.datetimepicker.css" rel="stylesheet" />
<script type="text/javascript" src="public/js/jsJquery.js"></script>
<script type="text/javascript" src="public/js/ckeditor/ckeditor.js"></script>
</head>

<body>
<div id="wrapper">

    <div id="header">
        <h1 class="logo">iAC <span>Webmaster</span></h1>
        
        <div class="user">
        	<span class="iconWhite iconUser"></span>Chào: <span class="b">Trần Nhân</span> | 
            <a href="" class="link"><span class="iconWhite iconPass"></span>Đổi mật khẩu</a>
            <a href="javascript:;" id="logout" class="link"><span class="iconWhite iconLogOut"></span>Logout</a>
            <script type="text/javascript">
			$(document).ready(function() {
                $("#logout").click(function(){
					var fields = new Object;
						fields._request = 'users';
						fields._action = 'logout';
						fields.session = 'admin';
					
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
								return false;
							}
							
							window.location = '/';
						}
					});
				});
            });
			</script>
        </div>
    </div>
	
    <div id="headerFixed"></div>
    
    <div id="left">
        <ul class="typeAdmin">
        	<li><a href="" class="btn btnSmall bgGray corner5">Web</a></li>
        	<li><a href="">Admin</a></li>
        	<li><a href="">Manager</a></li>
        </ul>
        
        <ul class="listMenu">
        	<?php
			$filter = array(
				'where' => array('type'=>'admin', 'status'=>true),
				'pretty' => array('label'=>1, 'name'=>1, 'icon'=>1),
				'sort' => array('order'=>1, '_id'=>-1),
			);
			$data = $control->model->find('pages', $filter);
            foreach($data as $key=>$row){
				if($row['name']!=$control->page){
					$active = '';
				}else{
					$active = ' class="active"';
				}
				if(isset($row['icon']) && $row['icon']!=''){
					$icon = $row['icon'];
				}else{
					$icon = 'iconDefault';
				}
				echo '<li><a href="/cp_admin/'.$row['name'].'"'.$active.'><span class="iconBlack '.$icon.'"></span>'.$row['label'].'</a></li>';
			}
			?>
        </ul>
        <script type="text/javascript">
		$(document).ready(function(e) {
            $("#left .listMenu a").mouseover(function(){
				$(this).children("span").removeClass("iconBlack").addClass("iconWhite");
			});
            $("#left .listMenu a").mouseout(function(){
				$(this).children("span").removeClass("iconWhite").addClass("iconBlack");
			});
        });
		</script>
    </div>

    <div id="right">
        <div class="headerRight">
        	<div class="navigator">
                <a href="cp_admin/"><span class="iconBlack iconHome"></span></a>&nbsp;
                <?php
                if($control->page!=''){
					echo '<span class="span">&gt;&gt;</span><a href="cp_admin/'.$control->page.'" class="link">'.ucfirst($control->page).'</a>';
				}
				?>
            </div>
            
            <div class="lang">
            	<a href="" class="link"><span class="iconBlack iconPosition"></span>English</a>
            </div>
            
            <div class="btnQuick">
                <p class="btnSubmitSave corner5"><span class="iconArticle iconBlack"></span>Save</p>
                <p class="btnClose corner5"><span class="iconBack iconBlack"></span>Back</p>
            </div>
        </div>
        
        <div class="viewContent">
        	<div class="clear10"></div>
            
            <!--<div id="search" class="corner3">
            	<form action="" method="get">
                	<input type="hidden" name="properties" value="2" />
                    <input type="hidden" name="type_id" value="8" />
                    <input type="text" name="LIKE_name" value="" class="txt" placeholder="Mô tả">
                    <select class="select" name="LIKE_menu_id">
                    	<option value="" selected="selected">-- chọn danh mục --</option>
                        <option value=",1399," >Home hoạt động Netspace</option>
                        <option value=",378," >Trang chủ</option>
                        <option value=",1411," >Thư viện</option>
                        <option value=",1412," >-- Thư viện hình ảnh</option>
                   	</select>
                    <input type="button" name="btnSearch" value="Tìm kiếm" class="btn" onclick="submit()">
                </form>
            </div>-->
            
            <?php echo $pageCurrent;?>
            
            <p style="clear:both; height:180px;"></p>
    	</div><!--end viewContent-->
    </div><!--end right-->

	<div class="clear1"></div>
</div><!--end wrapper-->

<div id="pp">
	<div id="ppViewData">
    	<div class="ppClose ppCloseStyle">x</div>
        <div class="clear10"></div>
    	<div id="ppContent"></div>
    </div>
    <div id="ppBG"></div>
</div>

<script type="text/javascript" src="public/js/jsGlobal.js"></script>
<script type="text/javascript" src="public/js/jquery-ui.js"></script>
<script src="public/js/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<script>
	function sortable(){
		$(".sortable").sortable();
		$(".sortable").disableSelection();
	}
	$(document).ready(function(e) {
        sortable();
    });
</script>
<script type="text/javascript">
$(".datetimepicker").datetimepicker({
	format: '<?php echo _DATETIME_;?>',
	formatDate: '<?php echo _DATETIME_DEFAULT_;?>',
});
$('.datepicker').datetimepicker({
	timepicker: false,
	format: '<?php echo _DATE_;?>',
	formatDate: '<?php echo _DATETIME_DEFAULT_;?>',
});
</script>
</body>
</html>