<?php
$collection = _COLLECTION_;
$filter = array(
	'where' => array('_id'=>$_GET['_id']),
);
$data = $this->model->findOne($collection, $filter);
?>

<ul class="iAC-Collection" name="<?php echo $collection;?>" action="<?php echo $this->action;?>">
	<li class="field" name="_id" type="text" check="string" condition="0">
        <ul class="values">
            <li class="field">
                <p class="value"><input type="text" name="_id" value="<?php echo $data['_id'];?>" class="field input hidden" /></p>
            </li>
        </ul>
    </li>
    
    <li class="field" name="name" type="text" check="string" condition="1">
        <span class="label">Collection name</span>
        <ul class="values">
            <li class="field">
                <p class="value"><input type="text" name="name" value="<?php echo $data['name'];?>" class="field input" /></p>
            </li>
            <p class="error hidden">Collection name is a required field</p>
        </ul>
        <p class="clear1"></p>
    </li>
    
    <li class="field" name="label" type="text" check="string" condition="1">
        <span class="label">Collection label</span>
        <ul class="values">
            <li class="field">
                <p class="value"><input type="text" name="label" value="<?php echo $data['label'];?>" class="field input" /></p>
            </li>
            <p class="error hidden">Collection label is a required field</p>
        </ul>
        <p class="clear1"></p>
    </li>
    
    <li class="field addData" name="fields" type="datalist" check="string" condition="1">
        <span class="label">Fields</span>
        <ul class="values dataListFull listAddData sortable">
            <p class="error hidden">Fields is a required field</p>
            <?php
            if(isset($data['fields'])){
				foreach($data['fields'] as $key=>$value){
					echo '<li class="field fieldAddData" key="'.$key.'" value="'.$value.'">'.$key.' <i>('.$value.')</i></li>';
				}
			}
			?>
        </ul>
        <div class="viewFrmAddData values80 floatRight">
            <input type="button" name="btnAddData" value="Add" class="btnAddData btnSmall bgGreen corner5" />
        </div>
        <p class="clear5"></p>
    </li>
    
    <li class="field" name="order" type="text" check="number" condition="1">
        <span class="label">Order</span>
        <ul class="values">
            <li class="field">
                <p class="value"><input type="text" name="order" value="<?php if(isset($data['order'])) echo $data['order']; else echo 0;?>" class="field input" /></p>
            </li>
            <p class="error hidden">Input number</p>
        </ul>
        <p class="clear1"></p>
    </li>
    
    <li class="field" name="submit" type="noaction">
        <span class="label"></span>
        <ul class="values">
            <p class="clear20"></p>
            <li class="field">
                <input type="button" name="iAC-Submit" value="Submit" class="iAC-Submit btnLarge bgBlue corner5" />
            </li>
        </ul>
    </li>
</ul>

<?php include_once('collections_add_data.php');?>

<script type="text/javascript">
$(document).ready(function() {
	ajaxSubmitFields();
});
</script>