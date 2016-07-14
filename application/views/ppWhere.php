<style type="text/css">
	#pp .viewpost {width:580px;}
	#pp .viewpost li {list-style:none;}
	#pp .viewpost .label {display:inline-block; width:33%; font-weight:bold; text-align:center;}
	#pp .viewpost .key {display:inline-block; width:33%;}
	#pp .viewpost .value {display:inline-block; width:33%;}
</style>
<div id="ppWhere" class="hidden">
	<div class="viewpost">
        <p><b>Ví dụ: tuổi của 1 người</b></p>
        <li><span class="label">age=15</span><span class="key">Key: "age"</span><span class="value">Value: "15"</span></li>
        <li><span class="label">age!=15</span><span class="key">Key: "age $ne"</span><span class="value">Value: "15"</span></li>
        <li><span class="label">age&gt;15</span><span class="key">Key: "age $gt"</span><span class="value">Value: "15"</span></li>
        <li><span class="label">age&gt;=15</span><span class="key">Key: "age $gte"</span><span class="value">Value: "15"</span></li>
        <li><span class="label">age&lt;15</span><span class="key">Key: "age $lt"</span><span class="value">Value: "15"</span></li>
        <li><span class="label">age&lt;=15</span><span class="key">Key: "age $lte"</span><span class="value">Value: "15"</span></li>
        <li><span class="label">age=15 AND age=18</span><span class="key">Key: "age $in"</span><span class="value">Value: "15, 18"</span></li>
        <li><span class="label">15&lt;age&lt;=18</span><span class="key">Key: "age $gt $lte"</span><span class="value">Value: "15, 18"</span></li>
        <li><span class="label">2016-01-01</span><span class="key">Key: "datetime $date"</span><span class="value">Value: "2016-01-01"</span></li>
        <li><span class="label">2016-01-01 &rarr; 2016-01-10</span><span class="key">Key: "datetime $date $gt $lt"</span><span class="value">Value: "2016-01-01, 2016-01-10"</span></li>
        <li><span class="label">$regex</span><span class="key">Key: "name $regex"</span><span class="value">Value: "/string/i"</span></li>
        <li><span class="label">True ? False</span><span class="key">Key: "status"</span><span class="value">Value: "true"</span></li>
        <li><span class="label">age&gt;=18 OR gender=1</span><span class="key">Key: "or | age $gte | gender"</span><span class="value">Value: "18 | 1"</span></li>
        <p align="right"><span class="btnSmall bgGray corner5 ppClose">Close</span></p>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$(".ppWhere").click(function(){
		var frm = $("#ppWhere").html();
		ppLoad(frm);
	});
});
</script>