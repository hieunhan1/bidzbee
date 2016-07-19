<!--<meta name="viewport" content="width=device-width, initial-scale=1">
<style type="text/css">
*{margin: 0}

/*mobile*/
@media all and (min-width: 320px) {
	#test {
		font-weight: bold;
	}
}

/*tablet*/
@media all and (min-width: 600px) {
	#test {
		font-size: 200%;	
	}
}

/*desktop*/
@media all and (min-width: 1024px) {
	#test {
		color: #F00;
	}
}
</style>
<div id="test">
	Trần Hiếu Nhân $
</div>-->


<script type="text/javascript" src="../public/js/jsJquery.js"></script>
<?php
session_start();
//session_destroy();

$data = array();

$a = array(
	array('type'=>'image', 'name'=>'name 1'),
	array('type'=>'image', 'name'=>'name 2'),
);

$data['data'] = $a;

$b = array(
	array('type'=>'image', 'name'=>'name 3'),
	array('type'=>'image', 'name'=>'name 4'),
);

foreach($b as $row){
	array_push($data['data'], $row);
}

echo '<pre>';
print_r($data);
echo '</pre>';
?>

<!--<div class="box" _id="">
<div class="bid_active">
    <p class="price_current btnBID">BID <span>20.000</span> đ</p>
    <p class="timeline"></p>
</div>
</div>-->

<style type="text/css">
.bid_active {
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
}
</style>

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
	var timeout = 120;
	timeline(timeout);
	
	function updateBID(autoTime){
		timeline(15);
	}
});
</script>



<!--
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
			$("#bid").show();
			return false;
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
</script>-->