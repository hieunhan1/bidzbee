<?php
$collection = 'widgets';
?>
<p class="btnCreate"><a href="cp_admin/<?php echo $collection;?>/?_id=0" class="btnSmall bgBlue corner5">Thêm mới</a></p>
<div id="adminContent">
    <table width="100%" border="1" cellpadding="0" cellspacing="0" class="adTable">
        <tr class="header">
            <th width="50">.NO</th>
            <th width="20%" align="left">Name</th>
            <th width="20%" align="left">Label</th>
            <th>&nbsp;</th>
        </tr>
        
        <?php
		$filter = array(
			'pretty' => array('name'=>1, 'label'=>1, 'status'=>1),
			'sort' => array('order'=>1, '_id'=>-1),
		);
		$data = $this->model->find($collection, $filter);
        if(count($data) > 0){
			foreach($data as $id=>$row){
				echo '<tr class="row" _id="'.$id.'">
					<td align="center"><input type="checkbox" name="listRow" value="'.$row['_id'].'" style="margin-top:7px"></td>
					<td>
						<p class="name height">'.$row['name'].'</p>
						<p class="action">&nbsp;
							<span class="hidden">
							<a href="javascript:;" class="status status1 corner5"></a>
							<a href="cp_admin/'.$collection.'/?_id='.$id.'" class="update iconBlack corner5"></a>
							<a href="javascript:;" class="delete iconBlack corner5"></a>
							</span>
						</p>
					</td>
					<td>'.$row['label'].'</td>
					<td>&nbsp;</td>
				</tr>';
			}
		}
		?>
    </table>
</div>