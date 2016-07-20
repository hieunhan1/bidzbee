<?
$strListProduct = '';
$highlights = '';
$i = 0;
$dateStart = '';
foreach($dataCurrent as $row){
	$i++;
	if($i==1){
		$dateStart = $row['date_bid'];
		$highlights = '<div class="box" _id="'.$row['_id'].'">
			<p class="img imgWidth"><img src="public/images/'.$row['img'].'" alt="'.$row['name'].'" /></p>
			<div class="info">
				<h3 class="name">'.$row['name'].'</h3>
				<p>Giá thị trường: <b>'.number_format($row['price_cost'], 0, ',', '.').'đ</b></p>
				<p class="price_start">Giá khởi điểm: <span>'.number_format($row['price_start'], 0, ',', '.').'đ</span></p>
				<p class="price_steps">Bước giá: <span>'.number_format($row['price_step'], 0, ',', '.').'đ</span></p>
				<p>Tình trạng máy: Full box - mới 99%</p>
				<p>Phí giao hàng: <b>'.$row['shipping'].'</b></p>
				<p>Thông tin sản phẩm: <span style="color:#999">'.$row['description'].'</p>
				<div id="bid" class="hidden">
					<div class="bid_active">
						<p class="price_current btnBID">BID <span>'.number_format($row['price_current'], 0, ',', '.').'</span> đ</p>
						<p class="timeline"></p>
						<p class="name_bid"></p>
					</div>
				</div>
				<div class="countdown">
					<p class="label">Count down:</p>
					<p class="datetime"><span id="d"></span> ngày - <span id="h"></span> : <span id="m"></span> : <span id="s"></span></p>
				</div>
				<p class="btn register">Đăng ký nhận thông báo</p>
			</div>
			
			<p class="clear1"></p>
		</div>';
	}else{
		if($i%2==0){
			$margin = '';
		}else{
			$margin = 'margin';
		}
		$strListProduct .= '<div class="box2 '.$margin.'">
			<p class="img imgWidth"><img src="public/images/'.$row['img'].'" alt="'.$row['name'].'" /></p>
			<div class="info">
				<h3>'.$row['name'].'</h3>
				<li>Giá thị trường: '.number_format($row['price_cost'], 0, ',', '.').'đ</li>
				<li>Giá khởi diểm: '.number_format($row['price_start'], 0, ',', '.').'đ</li>
				<li>Bước giá: '.number_format($row['price_step'], 0, ',', '.').'đ</li>
				<li>Ngày đấu: <b>'.date(_DATETIME_, $row['date_bid']->sec).'</b></li>
			</div>
		</div>';
	}
}

function countDown($date){
	print_r($date);
	//$start = date(_DATETIME_, $date->sec);
	$start = '2016-07-21 10:00:00';
	$start = strtotime($start);
	
	$current = date('Y-m-d H:i:s');
	$current = strtotime($current);
	
	$countdown = $start - $current;
	
	if($countdown>0){
		$d = $countdown / (60*60*24);
		settype($d, 'int');
		
		$countdown = $countdown % (60*60*24);
		$h = $countdown / (60*60);
		settype($h, 'int');
		
		$countdown = $countdown % (60*60);
		$m = $countdown / (60);
		settype($m, 'int');
		
		$s = $countdown % (60);
		settype($s, 'int');
	}else{
		$d=0; $h=0; $m=0; $s=0;
	}
	
	$str = '<div id="d_val" class="hidden">'.$d.'</div>
	<div id="h_val" class="hidden">'.$h.'</div>
	<div id="m_val" class="hidden">'.$m.'</div>
	<div id="s_val" class="hidden">'.$s.'</div>';
	return $str;
}








//form_contact
$_id=""; $name="";
if(isset($this->user["_id"])) $_id = $this->user["_id"];
if(isset($this->user["name"])) $name = $this->user["name"];
$html = '<div id="frmContact" class="hidden">
	<ul class="iAC-Collection" name="contact" action="create" style="width:500px">
        <li name="title" type="text" check="string" condition="1" class="field">
            <span class="label">Tiêu đề</span>
            <ul class="values values80">
                <li class="field"><p class="value"><input type="text" name="title" value="" class="field input" maxlength="30" /></p></li>
                <p class="error hidden">Nhập tiêu đề</p>
            </ul>
            <p class="clear1"></p>
        </li>
        <li name="content" type="textarea" check="string" condition="1" class="field">
            <span class="label">Nội dung</span>
            <ul class="values values80">
                <li class="field"><p class="value"><textarea name="content" class="field text"></textarea></p></li>
                <p class="error hidden">Nhập nội dung</p>
            </ul>
            <p class="clear1"></p>
        </li>
        <li name="user" type="datalist" check="string" condition="1" class="field" style="display:none;">
            <ul class="values">
                <li class="field" value="_id">'.$_id.'</li>
                <li class="field" value="name">'.$name.'</li>
            </ul>
            <p class="clear1"></p>
        </li>
        <li name="datetime" type="datetime" check="datetime" condition="1" class="field" style="display:none;">
            <ul class="values">
                <li class="field"><p class="value"><input type="datetime" name="datetime" value="'.date(_DATETIME_).'" class="field" /></p></li>
            </ul>
        </li>
        <li name="status" type="radio" check="string" condition="1" class="field" style="display:none;">
            <ul class="values">
                <li class="field"><p class="value"><input type="radio" name="status" value="0" checked="checked" class="field" /></p></li>
            </ul>
        </li>
        <li class="field" name="submit" type="noaction">
            <span class="label"></span>
            <ul class="values">
                <li class="field">
                    <input type="button" name="iAC-Submit" value="Gửi" class="iAC-Submit btnMedium bgBlue corner5" />
                    <input type="button" name="btnClose" value="Đóng" class="ppClose btnMedium bgGray corner5" />
                </li>
            </ul>
        </li>
    </ul>
</div>';

$html .= $css.$javascript;