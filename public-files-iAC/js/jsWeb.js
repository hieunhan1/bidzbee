/*
function browserName(){
	var Browser = navigator.userAgent;
	if (Browser.indexOf('MSIE') >= 0){
		Browser = 'MSIE';
	}else if (Browser.indexOf('Firefox') >= 0){
		Browser = 'Firefox';
	}else if (Browser.indexOf('Chrome') >= 0){
		Browser = 'Chrome';
	}else if (Browser.indexOf('Safari') >= 0){
		Browser = 'Safari';
	}else if (Browser.indexOf('Opera') >= 0){
		Browser = 'Opera';
	}else{
		Browser = 'UNKNOWN';
	}
	return Browser;
}

function browserVersion(){
	var index;
	var version = 0;
	var name = browserName();
	var info = navigator.userAgent;
	index = info.indexOf(name) + name.length + 1;
	version = parseFloat(info.substring(index,index + 3));
	return version;
}

function isInt(num){
	if(parseInt(num)==num) return true;
	else return false;
}
*/

function facebook_share(link_share){
	if(link_share=='') link_share = location.href;
	myWindow=window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(link_share),'','width=600,height=450');
	myWindow.focus();
	return false;
}

function SearchGoogle(id_txt_search){
	var key = document.getElementById(id_txt_search).value;
	var site = document.domain;
	var qs = key + "+site:" + site;
	var url = "http://www.google.com.vn/#sclient=psy-ab&hl=vi&site=&source=hp&q=" + qs + "&pbx=1&oq=" + qs + "&aq=f&aqi=&aql=1&gs_sm=e";
	window.open(url, "_blank");
	return false;
}

function SearchWebsite(id_txt_search){
	var key = document.getElementById(id_txt_search).value;
	var site = document.domain;
	var url = 'http://' + site + '/search/?txt=' + key;
	window.location = url;
	return true;
}

$(document).ready(function($){
	$("#txtSearch").keydown(function(e){
		if(e.keyCode==13) SearchWebsite("txtSearch");
	});
	$("input[name=btnSearch]").click(function(){
		SearchGoogle("txtSearch");
	});
	
	$(".btnTop").click(function(){
		sroll_top();
	});
	
	/*view mobile*/
	function viewMobile(){
		var width = parseInt($(window).width());
		if(width<=550){
			$("#menuMobile").show();
			var main = new Array();
			$(".menuMobile").each(function(index, element) {
				var order = index;
				if( $(this).attr("order") ){
					order = parseInt( $(this).attr("order") );
				}
				main[order] = $(this).html();
				$(this).hide();
            });
			
			var strMain = '';
			for(var i=0; i<main.length; i++){
				strMain += main[i];
			}
			
			var data = '<div class="closeMobile" style="top:0"></div>';
				data+= strMain;
				data+= '<div class="closeMobile"></div>';
			$("#viewMobile").html(data);
		}else{
			$("#menuMobile").hide();
			$("#menuMain, #menuTop").show();
			$("#viewMobile").html('');
		}
	}
	viewMobile();
	$("#btnMobile").live("click", function(){
		$("#viewMobile").show(100);
	});
	$(".closeMobile").live("click", function(){
		$("#viewMobile").hide(100);
	});
	/*end view mobile*/
	
	
	
	/**********************************/
	/*************OTHER****************/
	/**********************************/
	function autoSizeBoxPhotos(){
		if( !$(".library-photos").length ) return false;
		
		var width = parseInt( $(".library-photos .bg img").width() );
		var height = parseInt( $(".library-photos .bg img").height() );
		
		var widthImg = parseInt( width * (1-0.13) );
		var heightImg = parseInt( height * (1-0.425) );
		
		var marginTop = parseInt( (height - heightImg) * 0.59 );
		var marginLeft = parseInt( (width - widthImg) / 2 );
		$(".library-photos .box-img").height(height);
		$(".library-photos .img").css({width:widthImg, height:heightImg, 'margin-top':marginTop + 'px', 'margin-left':marginLeft + 'px'});
	}
	autoSizeBoxPhotos();
	
	function autoSizeBoxVideos(){
		if( !$(".library-videos").length ) return false;
		
		var width = parseInt( $(".library-videos .bg img").width() );
		var height = parseInt( $(".library-videos .bg img").height() );
		
		var widthImg = parseInt( width * (1-0.31) );
		
		$(".library-videos .box-img").height(height);
		$(".library-videos .img").css({width:widthImg, height:height});
	}
	autoSizeBoxVideos();
	
	
	/*function autoMouseViewmoreSize(){
		$(".mouseViewmore").each(function(i, val){
			var height = parseInt( $(this).height() );
			var width = parseInt( $(this).width() );
			$(this).children(".viewmore").css({"width":width, "height":height, "line-height": height + 'px'});
		});
	}
	autoMouseViewmoreSize();
	$(".mouseViewmore").mouseover(function(){
		$(this).children(".viewmore").show();
	});
	$(".mouseViewmore").mouseout(function(){
		$(this).children(".viewmore").hide();
	});*/
	
	//why choose us
	$("#whychooseus .tab .content").hide();
	$("#whychooseus .tab .content:first").show();
	$("#whychooseus .tab .h3").click(function(){
		$("#whychooseus .tab .content").hide(200);
		$(this).parent().children(".content").show(200);
	});
	
	/*resize window*/
	$(window).bind("resize", function(){
		viewMobile();
		autoSizeBoxPhotos();
		autoSizeBoxVideos();
	});
	/*end resize window*/
});