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
	
<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

include_once("../application/config/config.php");
include_once("../application/models/modelAjax.php");

$control = new modelAjax();

$filter = array(
	'where' => array(
		'status' => true,
		'page' => 'product',
		'properties' => 'articles',
		'date_bid' => array(
			'$gte'=>$control->_dateObject(time()-50),
			'$lte'=>$control->_dateObject(time())
		),
	),
	'pretty' => array('name'=>1, 'img'=>1, 'price_cost'=>1, 'price_start'=>1, 'price_step'=>1, 'price_current'=>1, 'count_bid'=>1),
	'limit' => 3,
);


echo '<div style="clear:both">'.date('d-m-Y H:i:s').'</div>';
//echo $control->_print($filter);

$dataCurrent = $control->find('posts', $filter);
echo count($dataCurrent);
	
$strBID = '';
foreach($dataCurrent as $id=>$row){
	$price_cost = ' ';
	$sale_off = ' ';
	if($row['price_cost']!=0){
		$price_cost = number_format($row['price_cost'], 0, ',', '.').' Đ';
		$sale_off = 100 - ($row['price_start']/$row['price_cost']*100);
		$sale_off = (int)$sale_off.'% OFF';
	}
	if(isset($row['count_bid'])){
		$count_bid = (int)$row['count_bid'];
	}else{
		$count_bid = 0;
	}
	
	$strBID .= '<div class="box-bid" id="'.$id.'">
		<p class="img imgHeight"><img src="'._URL_THUMB_.$row['img'].'" alt="" /></p>
		<p class="action-bid gray">Đang xử lý..</p>
		<p class="time-bid"><span></span></p>
		<div class="info-bid">
			<p class="count-bid">'.$count_bid.' BIDS</p>
			<p class="price-cost">'.$price_cost.'</p>
			<p class="sale-off">'.$sale_off.'</p>
			<p class="clear1"> </p>
		</div>
	</div>';
}

$html = '<div class="product-list container">'.$strBID.'<p class="clear1"></p></div>';
	
echo $html;
?>
    
    
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
	function timeline(){
		$(".product-list .box-bid").each(function(index, element) {
            var time = $(element).find(".time-bid").width();
			var current = $(element).find(".time-bid span").width() - 6;
			
			$(element).find(".time-bid span").width(current);
        });
	}
	setInterval(function(){
		timeline();
	}, 250);
	
	function nextBID(id, time){
		$("#" + id + " .action-bid").attr("class", "action-bid gray");
		$("#" + id + " .time-bid span").width(time*10 + "%");
		$("#" + id + " .time-bid span").attr("class", "gray");
	}
	
	function startBID(id, time, count, type, fulltime){
		var bgColor;
		if(time <= 10){
			bgColor = 'red';
		}else if(time <= 20){
			bgColor = 'yellow';
			time = time - 10;
		}else{
			bgColor = 'green';
			time = time - 20;
		}
		
		if(type=='bid'){
			var btn = 'btn-bid';
		}else if(type=='login'){
			var btn = 'btnRegister';
		}else{
			var btn = '';
		}
		
		if(fulltime==true){
			fulltime = ' timeline-full';
		}else{
			fulltime = '';
		}
		
		$("#" + id + " .action-bid").attr("class", "action-bid blue " + btn);
		$("#" + id + " .time-bid span").width(time*10 + "%");
		$("#" + id + " .time-bid span").attr("class", bgColor + fulltime);
		$("#" + id + " .count-bid").html(count + " BIDS");
	}
	
	function endBID(id, time, count){
		$("#" + id + " .action-bid").attr("class", "action-bid gray");
		$("#" + id + " .time-bid span").width(time/10*100 + "%");
		$("#" + id + " .time-bid span").attr("class", "gray");
		$("#" + id + " .count-bid").html(count + " BIDS");
	}
	
	function actionBID(data, fulltime){
		var id = data._id;
		
		if(data.result!=false){
			$("#" + id + " .action-bid").html(data.message);
			if(data.status == 'wait'){
				nextBID(id, data.time);
			}else if(data.status == 'bid'){
				startBID(id, data.time, data.count, data.type, fulltime);
			}else if(data.status == 'end'){
				endBID(id, data.time, data.count);
			}else{
				var width = $("#" + id).width();
					$("#" + id).width(width)
					
				var height = $("#" + id).height();
					$("#" + id).height(height)
				
				$("#" + id).attr("class", "box-empty");
				$("#" + id).html("");
			}
		}else{
			console.log(data);
		}
	}
	
	function viewBidNew(data){
		var i = 0;
		for(var id in data){
			i++;
			if( $(".box-empty").length ){
				$(".box-empty").each(function(index, element) {
					if(i > index){
						$(element).html(data[id]);
						$(element).attr("id", id);
						$(element).attr("class", "box-bid");
					}
                });
			}else{
				var str = '<div class="box-bid" id="' + id + '">' + data[id] + '</div>';
				$(".product-list").append(str);
			}
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
				//console.log(data);
				
				if(typeof data.result!="undefined"){
					actionBID(data, true);
				}else{
					for(var i in data){
						if(i!='data'){
							actionBID(data[i]);
						}else{
							viewBidNew(data[i]);
						}
					}
				}
			}
		});
	}
	
	var id = new Array();
	$(".product-list .box-bid").each(function(index, element) {
		id[index] = $(element).attr("id");
	});
	if(id.length > 0){
		BID(id);
	}
	
	var i = 0
	setInterval(function(){
		var id = new Array();
		$(".product-list .box-bid").each(function(index, element) {
			id[index] = $(element).attr("id");
		});
		if(id.length > 0){
			BID(id);
		}
	}, 1000);
	
	$(".product-list").on("click", ".btn-bid", function(){
		var id = $(this).parents(".box-bid").attr("id");
		//clearTimeout(timeout);
		BID(id, 1);
	});
});
</script>

<style type="text/css">
.container{width: 98%;}
.clear1{clear: both; height:1px;}

@media all and (min-width: 270px) {
	.product-list{
		clear: both;
		margin-bottom: 30px;
	}
	.box-bid, .box-empty{
		width: 70%;
		margin: auto auto 4% auto;
		padding: 4% 5%;
		border: solid 1px #CCC;
	}
	.box-bid .img{
		width: 100%;
		height: 220px;
		margin-bottom: 5px;
	}
	.box-bid .gray{
		background-color: #BBB;
	}
	.box-bid .blue{
		background-color: #6273b9;
	}
	.box-bid .green{
		background-color: #219c00;
	}
	.box-bid .yellow{
		background-color: #ffb400;
	}
	.box-bid .red{
		background-color: #ff3c3c;
	}
	.box-bid .action-bid{
		line-height: 35px;
		color: #FFF;
		font-weight: bold;
		text-align: center;
		text-transform: uppercase;
		border-radius: 5px;
		cursor: not-allowed;
	}
	.box-bid .btn-bid{
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
		width: 0%;
		height: 5px;
		border-radius: 5px;
		-webkit-transform:width 0.25s ease;
		transition:width 0.25s ease;
	}
	.box-bid .info-bid{
		clear: both;
		line-height: 35px;
	}
	.box-bid .info-bid .count-bid{
		width: 31%;
		float: left;
	}
	.box-bid .info-bid .price-cost{
		width: 37%;
		float: left;
		text-align: center;
	}
	.box-bid .info-bid .sale-off{
		width: 31%;
		float: right;
		font-weight: bold;
		text-align: right;
	}
}

@media all and (min-width: 500px) {
	.box-bid, .box-empty{
		width: 41.5%;
		float: left;
		margin: 2%;
		padding: 2%;
	}
}

@media all and (min-width: 750px) {
	.box-bid, .box-empty{
		width: 29.4%;
		margin: 0.8%;
		padding: 1%;
	}
}

@media all and (min-width: 1024px) {
	.box-bid, .box-empty{
		width: 21.1%;
		margin: 0.8%;
		padding: 1%;
	}
}
</style>

