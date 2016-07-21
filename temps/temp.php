
<!Doctype html>
<html>
<head>
    <base href="http://bidzbee.localhost/" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bidzbee - Đấu giá trực tiếp</title><meta name="description" content="Bidzbee - Đấu giá trực tiếp là nơi mua bán sản phẩm bằng hình thức ĐẤU GIÁ TRỰC TIẾP" /><meta name="keywords" content="bidzbee,đấu giá trực tiếp,dau gia truc tiep" /><meta name="robots" content="index,follow" />
<link type="icon/x-icon" href="public/themes/favicon.ico" rel="shortcut icon" />
<link type="text/css" href="public/themes/admin/global.css" rel="stylesheet" />
<script type="text/javascript" src="public/js/jsJquery.js"></script>
<script type="text/javascript" src="public/js/jsGlobal.js"></script>
</head>

<body>
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-78073712-1', 'auto');
  ga('send', 'pageview');
</script>
    
    <div class="product-list container">
		<div class="box-bid" id="577f52dc1fabf3e03400002d">
        	<p class="img imgWidth"><img src="http://bidzbee.localhost/public/images/iphone.jpg" alt="" /></p>
            <p class="btn-bid">BID <span>20.000</span> Đ</p>
            <p class="time-bid"><span></span></p>
            <div class="info-bid">
            	<p class="count-bid"><span>0</span> BIDS</p>
                <p class="price-cost">200.000đ</p>
                <p class="sale-off">90% OFF</p>
                <p class="clear1"></p>
            </div>
        </div>
		<div class="box-bid" id="22">
        	<p class="img imgWidth"><img src="http://bidzbee.localhost/public/images/iphone.jpg" alt="" /></p>
            <p class="btn-bid">BID <span>20.000</span> Đ</p>
            <p class="time-bid"><span></span></p>
            <div class="info-bid">
            	<p class="count-bid"><span>0</span> BIDS</p>
                <p class="price-cost">200.000đ</p>
                <p class="sale-off">90% OFF</p>
                <p class="clear1"></p>
            </div>
        </div>
		<div class="box-bid" id="33">
        	<p class="img imgWidth"><img src="http://bidzbee.localhost/public/images/iphone.jpg" alt="" /></p>
            <p class="btn-bid">BID <span>20.000</span> Đ</p>
            <p class="time-bid"><span></span></p>
            <div class="info-bid">
            	<p class="count-bid"><span>0</span> BIDS</p>
                <p class="price-cost">200.000đ</p>
                <p class="sale-off">90% OFF</p>
                <p class="clear1"></p>
            </div>
        </div>
		<div class="box-bid" id="44">
        	<p class="img imgWidth"><img src="http://bidzbee.localhost/public/images/iphone.jpg" alt="" /></p>
            <p class="btn-bid">BID <span>20.000</span> Đ</p>
            <p class="time-bid"><span></span></p>
            <div class="info-bid">
            	<p class="count-bid"><span>0</span> BIDS</p>
                <p class="price-cost">200.000đ</p>
                <p class="sale-off">90% OFF</p>
                <p class="clear1"></p>
            </div>
        </div>
		<div class="box-bid" id="55">
        	<p class="img imgWidth"><img src="http://bidzbee.localhost/public/images/iphone.jpg" alt="" /></p>
            <p class="btn-bid">BID <span>20.000</span> Đ</p>
            <p class="time-bid"><span></span></p>
            <div class="info-bid">
            	<p class="count-bid"><span>0</span> BIDS</p>
                <p class="price-cost">200.000đ</p>
                <p class="sale-off">90% OFF</p>
                <p class="clear1"></p>
            </div>
        </div>
		<div class="box-bid" id="66">
        	<p class="img imgWidth"><img src="http://bidzbee.localhost/public/images/iphone.jpg" alt="" /></p>
            <p class="btn-bid">BID <span>20.000</span> Đ</p>
            <p class="time-bid"><span></span></p>
            <div class="info-bid">
            	<p class="count-bid"><span>0</span> BIDS</p>
                <p class="price-cost">200.000đ</p>
                <p class="sale-off">90% OFF</p>
                <p class="clear1"></p>
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
</body>

</html>
<script type="text/javascript">
$(document).ready(function() {
	function timeline(timeout){
		if(timeout > 0){
			console.log(timeout);
			timeout--;
			var total = 120;
			var percent = (timeout/total) * 100;
				percent = parseInt(percent);
				
			$(".bid_active .timeline").width(percent + '%');
			
			if(timeout%12 == 0){
				updateBID();
				return false;
			}
				 
			setTimeout(function(){
				timeline(timeout);
			}, 250);
		}else{
			return false;
		}
	}
	
	function BID(id, bid){
		var fields = new Object();
			fields._request = "BID";
			fields._id = id;
			fields.bid = bid;
		
		$.ajax({
			url     : 'ajax',
			type    : 'post',
			data    : fields,
			cache   : false,
			success : function(data){
				data = convertToJson(data);
				
				if(data==false){
					return false;
				}
				
				if(data.result!=false){
					$("#" + id + " .btn-bid span").html(data.message);
					console.log(data);
				}else{
					console.log(data);
				}
				
				
				return true;
				
				if(data.result!=false){
					var price = $(".bid_active .price_current span").html();
					if(typeof data.data != "undefined"){
						$(".bid_active .name_bid").html(data.data.name);
						if(data.data.price != price){
							$(".bid_active .price_current span").html(data.data.price);
						}
						timeline(data.data.time * 4);
					}else{
						$(".bid_active .name_bid").html(data.message);
						$(".bid_active .timeline").width(0);
					}
				}else{
					ppLoad(data.message);
				}
			}
		});
	}
	BID("577f52dc1fabf3e03400002d");
	
	$(".product-list").on("click", ".btn-bid", function(){
		var id = $(this).parents(".box-bid").attr("id");
		BID(id, 1);
	});
});
</script>

<style type="text/css">
/*mobile*/
.container{width: 98%;}
.clear1{clear: both; height:1px;}

@media all and (min-width: 270px) {
	.box-bid{
		width: 70%;
		margin: auto auto 4% auto;
		padding: 4% 5%;
		border: solid 1px #CCC;
	}
	.box-bid .img{
		width: 100%;
		margin-bottom: 5px;
	}
	.box-bid .btn-bid{
		line-height: 35px;
		color: #FFF;
		text-align: center;
		background-color: #6273b9;
		border-radius: 5px;
		cursor: pointer;
	}
	.box-bid .btn-bid:hover{
		background-color: #4859a0;
	}
	.box-bid .time-bid{
		clear: both;
		width: 100%;
		margin: 1px 0;
	}
	.box-bid .time-bid span{
		display: block;
		width: 100%;
		height: 5px;
		background-color: #219c00;
		border-radius: 5px;
	}
	.box-bid .info-bid{
		clear: both;
		line-height: 35px;
	}
	.box-bid .info-bid .count-bid{
		width: 33%;
		float: left;
	}
	.box-bid .info-bid .price-cost{
		width: 33%;
		float: left;
		text-align: center;
	}
	.box-bid .info-bid .sale-off{
		width: 33%;
		float: right;
		font-weight: bold;
		text-align: right;
	}
}

@media all and (min-width: 500px) {
	.box-bid{
		width: 41.5%;
		float: left;
		margin: 2%;
		padding: 2%;
	}
}

@media all and (min-width: 750px) {
	.box-bid{
		width: 29.4%;
		margin: 0.8%;
		padding: 1%;
	}
}

@media all and (min-width: 1024px) {
	.box-bid{
		width: 21.1%;
		margin: 0.8%;
		padding: 1%;
	}
}
</style>


<style type="text/css">
#header{
	height: 60px;
	background-color: #fbc900;
	margin-bottom: 30px;
}
#logo{
	width: auto;
	height: 48px;
	float: left;
	margin-top: 6px;
}
#menu{
	list-style: none;
	width: auto;
	float: right;
	line-height: 24px;
	padding: 18px 0;
}
#menu li{
	width: auto;
	float: left;
}
#menu li a{
	color: #333;
	font-size: 120%;
	padding: 0 25px 0 10px;
}
#menu .icon{
	width: 23px;
	height: 23px;
	display: inline-block;
	float: left;
	background: url(img/icon.png) no-repeat;
}
#user{
	list-style: none;
	width: auto;
	float: right;
	line-height: 24px;
	margin-top: 9px;
	padding: 8px;
	box-shadow: 0px 0px 3px #333;
	border-radius: 5px;
}
#user li{
	width: auto;
	float: left;
}
#user li a{
	color: #333;
	font-size: 120%;
	padding: 0 10px;
}</style><style type="text/css">#footer{
	clear: both;
	line-height: 24px;
	color: #666;
	padding: 20px 0;
	background-color: #F1F1F1;
	border-top: solid 1px #CCC;
	box-shadow: 0px 0px 3px #CCC;
}
#footer .facebook{
	display: inline-block;
	width: 24px;
	height: 24px;
	clear: left;
	line-height: 24px;
	color: #FFF;
	font-weight: bold;
	font-size: 15px;
	text-align: center;
	margin-right: 5px;
	background-color: #3b5998;
}
#footer .left{
	width: auto;
	float: left;
}
#footer .right{
	width: auto;
	float: right;
	font-weight: bold;
}
</style>
<style type="text/css">
#footer{
	clear: both;
	line-height: 24px;
	color: #666;
	padding: 20px 0;
	background-color: #F1F1F1;
	border-top: solid 1px #CCC;
	box-shadow: 0px 0px 3px #CCC;
}
#footer .facebook{
	display: inline-block;
	width: 24px;
	height: 24px;
	clear: left;
	line-height: 24px;
	color: #FFF;
	font-weight: bold;
	font-size: 15px;
	text-align: center;
	margin-right: 5px;
	background-color: #3b5998;
}
#footer .left{
	width: auto;
	float: left;
}
#footer .right{
	width: auto;
	float: right;
	font-weight: bold;
}
</style>
<style type="text/css">
.frmRegister{
	width: auto;
}
.frmRegister .box{
	clear: both;
	margin-bottom: 20px;
}
.frmRegister .google{
	width: auto;
	float: left;
}
.frmRegister .facebook{
	width: 120px;
	height: 34px;
	float: left;
	line-height: 34px;
	color: #666;
	font-size: 100%;
	text-align: center;
	margin-right: 10px;
	cursor: pointer;
	border: solid 1px #EEE;
	box-shadow: 0px 2px 5px #CCC;
}
.frmRegister .facebook:hover{
	box-shadow: 0px 0px 8px #3c66c4;
}
.frmRegister .facebook .iconF{
	display: inline-block;
	width: 34px;
	height: 34px;
	float: left;
	color: #3c66c4;
	font-size: 150%;
	font-weight: bold;
	background-color: #FFF;
}
</style>
<style type="text/css">
.frmRegister{
	width: auto;
}
.frmRegister .box{
	clear: both;
	margin-bottom: 20px;
}
.frmRegister .google{
	width: auto;
	float: left;
}
.frmRegister .facebook{
	width: 120px;
	height: 34px;
	float: left;
	line-height: 34px;
	color: #666;
	font-size: 100%;
	text-align: center;
	margin-right: 10px;
	cursor: pointer;
	border: solid 1px #EEE;
	box-shadow: 0px 2px 5px #CCC;
}
.frmRegister .facebook:hover{
	box-shadow: 0px 0px 8px #3c66c4;
}
.frmRegister .facebook .iconF{
	display: inline-block;
	width: 34px;
	height: 34px;
	float: left;
	color: #3c66c4;
	font-size: 150%;
	font-weight: bold;
	background-color: #FFF;
}</style>
<style type="text/css">.bid_active {
	width: 300px;
	margin: 30px;
}
.bid_active .price_current{
	height: 45px;
	line-height: 45px;
	font-family: Arial, Helvetica, sans-serif;
	color: #FFF;
	font-size: 100%;
	font-weight: bold;
	text-align: center;
	margin-bottom: 5px;
	background-color: #2283c5;
	border-radius: 5px;
	cursor: pointer;
}
.bid_active .price_current:hover{
	background-color: #1c6a9f;
}
.bid_active .price_current span{
	font-size: 120%;
}
.bid_active .timeline{
	height: 10px;
	background-color: #F00;
	border-radius: 5px;
	-webkit-transform:width 0.2s ease;
	transition:width 0.2s ease;
}
</style>
<script type="text/javascript">
function checkUsers(fields){
	$.ajax({
		url: 'ajax',
		type:'POST',
		data:fields,
		cache:false,
		success: function(data) {
			console.log(data)
			data = $.parseJSON(data);
			if(data.result!=false){
				$(".register").hide(100);
				var str = '';
					str+= '<li><a href="javascript:;">' + data.name + '</a></li>';
					str+= '<li>|</li>';
					str+= '<li><a href="javascript:;" id="logout">Logout</a></li>';
				
				$("#user").html(str);
				ppClose();
				window.location.reload();
			}
		}
	});
}

$(document).ready(function() {
	$(".register").click(function(){
		var fields = new Object();
			fields._request = 'loginUser';
			
		$.ajax({
			url: 'ajax',
			type: 'POST',
			data: fields,
			cache: false,
			success: function(data){
				//console.log(data);
				data = $.parseJSON(data);
				ppLoad(data.data);
				//console.log(data);
			}
		});
	});
	
	$("#header").on("click", "#logout", function(){
		var fields = new Object();
			fields._request = 'logoutUser';
			
		$.ajax({
			url: 'ajax',
			type: 'POST',
			data: fields,
			cache: false,
			success: function(){
				window.location.reload();
			}
		});
	});
	
	$("#btnAbout").click(function(){
		var str = $("#about").html();
		ppLoad(str);
	});
});
</script>


<script type="text/javascript">
$(document).ready(function() {
	var d = null; // ngày
	var h = null; // Giờ
	var m = null; // Phút
	var s = null; // Giây
	var timeout = null; // Timeout
	function startTime(){
		/*BƯỚC 1: LẤY GIÁ TRỊ BAN ĐẦU*/
		if (d == null){
			d = parseInt( $("#d_val").html() );
			h = parseInt( $("#h_val").html() );
			m = parseInt( $("#m_val").html() );
			s = parseInt( $("#s_val").html() );
		}
	 
		/*BƯỚC 1: CHUYỂN ĐỔI DỮ LIỆU*/
		// Nếu số giây = -1 tức là đã chạy ngược hết số giây, lúc này:
		//  - giảm số phút xuống 1 đơn vị
		//  - thiết lập số giây lại 59
		if (s == -1){
			m -= 1;
			s = 59;
		}
	 
		// Nếu số phút = -1 tức là đã chạy ngược hết số phút, lúc này:
		//  - giảm số giờ xuống 1 đơn vị
		//  - thiết lập số phút lại 59
		if (m == -1){
			h -= 1;
			m = 59;
		}
	 
		// Nếu số giờ = -1 tức là đã chạy ngược hết số giớ, lúc này:
		//  - giảm số ngày xuống 1 đơn vị
		//  - thiết lập số giờ lại 23
		if (h == -1){
			d -= 1;
			h = 23;
		}
	 
		// Nếu số ngày = -1 tức là đã hết giờ, lúc này:
		//  - Dừng chương trình
		if (d == -1){
			clearTimeout(timeout);
			//alert('Hết giờ');
			$(".productList .box .countdown").hide();
			$(".productList .box .btn").hide();
			$(".bid").show();
			return false;
		}else{
			$(".countdown").show();
		}
	 
		/*BƯỚC 1: HIỂN THỊ ĐỒNG HỒ*/
		if(h < 10){
			h = parseInt(h);
			h = '0' + h;
		}
		if(m < 10){
			m = parseInt(m);
			m = '0' + m;
		}
		if(s < 10){ s = '0' + s; }
		$("#d").html(d);
		$("#h").html(h);
		$("#m").html(m);
		$("#s").html(s);
		
		/*BƯỚC 1: GIẢM PHÚT XUỐNG 1 GIÂY VÀ GỌI LẠI SAU 1 GIÂY */
		timeout = setTimeout(function(){
			s--;
			startTime();
		}, 1000);
	}
	function stopTime(){
		clearTimeout(timeout);
	}
	
	startTime();
});
</script>