<?php
class admin{
    public $model;
	public $user;
    public $page;
    public $collection;
    public $action;
    
    public function __construct(){
		include_once('models/modelAdmin.php');
		$this->model = new modelAdmin;
		
		$this->getPage();
        $this->handle();
    }
    
    private function handle(){
		$_SESSION['admin'] = array(
			'id' => '25',
			'name' => 'Trần Nhân',
			'username' => 'admin',
			//'groups' => 'administrators',
			//'groups' => 'everyone',
			'groups' => array('everyone', 'administrators'),
		);
		//unset($_SESSION['admin']);
		
		$this->user = $_SESSION['admin'];
    }
	
	private function getPage(){
		global $currentUrl;
		$this->page = '';
		if(isset($currentUrl['other'])){
			$this->page = $currentUrl['other'][0];
		}
		
		if(!isset($_GET['_id'])){
			$this->action = '';
		}else{
			if($_GET['_id']=='' || $_GET['_id']=='0'){
				$this->action = 'create';
			}else{
				$this->action = 'update';
			}
		}
	}
	
	public function pageCurrent(){
		$filter = array(
			'where' => array('name'=>$this->page),
		);
		$dataPages = $this->model->findOne(_PAGES_, $filter);
		
		if(count($dataPages) > 0){
			if(isset($dataPages['collection']) && $dataPages['collection']!=''){
				$this->collection = $dataPages['collection'];
			}else{
				return 'Trang chưa kết nối dữ liệu';
			}
			
			if(!isset($_GET['_id'])){
				$html = $this->pageView($dataPages);
			}else{
				$html = $this->pageAction($dataPages, $_GET['_id']);
			}
		}else{
			//page default
			$html = ob_start();
			if(!isset($_GET['_id'])){
				$file = 'views/'.$this->page.'.php';
			}else{
				$file = 'views/'.$this->page.'_ac.php';
			}
			if(file_exists($file)){
				include_once($file);
			}else{
				echo '<p>ERROR: Trang không tồn tại</p>';
			}
			$html = ob_get_clean();
		}
		
		return $html;
	}
	
	public function pageView($dataPages){
		//lay thong tin data trang hiện tại
		$dataCurrent = array();
		if($this->collection != ''){
			$filter = $this->model->_getCollectionFilter($dataPages);
			$dataCurrent = $this->model->find($this->collection, $filter);
		}
		//end lay thong tin data trang hiện tại
		
		//vòng lặp xuất data
		$html = '';
		if(isset($dataPages['php']) && $dataPages['php']!=''){
			eval($dataPages['php']);
		}else{
			$strRow = '';
			$pretty = $dataPages['pretty'];
			if($dataCurrent){
				foreach($dataCurrent as $key=>$row){
					if(isset($row['status'])){
						$status = '<a href="javascript:;" class="status status1 corner5"></a>';
					}else{
						$status = '';
					}
					
					$column = '<td align="center"><input type="checkbox" name="listRow" value="'.$row['_id'].'" style="margin-top:7px" /></td>
					<td>
						<p class="name height">'.$row['name'].'</p>
						<p class="action"> 
							<span class="hidden">
							'.$status.'
							<a href="cp_admin/'.$this->page.'/?_id='.$row['_id'].'" class="update iconBlack corner5"></a>
							<a href="javascript:;" class="delete iconBlack corner5"></a>
							</span>
						</p>
					</td>';
					
					foreach($pretty as $field){
						if($field!='name' && $field!='status'){
							$str = '&nbsp;';
							if(isset($row[$field])){
								$gettype = gettype($row[$field]);
								if($gettype!='array' && $gettype!='object'){
									$str = $row[$field];
								}else if($gettype=='object'){
									$str = $this->model->_dateMongo($row[$field], _DATETIME_);
								}else{
									foreach($row[$field] as $value){
										$str .= $value.', ';
									}
									$str = trim($str, ', ');
								}
							}
							$column .= '<td><p class="height">'.$str.'</p></td>';
						}
					}
					
					$strRow .= '<tr class="row" _id="'.$row['_id'].'">'.$column.'</tr>';
				}
			}
			
			$label = '';
			$i = 0;
			foreach($pretty as $field){
				if($field!='name' && $field!='status'){
					$i++;
					$label .= '<th width="{width}%" align="left">'.ucfirst($field).'</th>';
				}
			}
			$width = 15;
			if($i == 1) $width = 35;
			if($i == 2) $width = 25;
			if($i == 3) $width = 20;
			$label = str_replace('{width}', $width, $label);
			
			$html = '<p class="btnCreate"><a href="cp_admin/'.$this->page.'/?_id=0" class="btnSmall bgBlue corner5">Thêm mới</a></p>
			<div id="adminContent">
				<table width="100%" border="1" cellpadding="0" cellspacing="0" class="adTable">
					<tr class="header">
						<th width="50">.NO</th>
						<th align="left">Name</th>
						'.$label.'
					</tr>
					'.$strRow.'
				</table>
			</div>';
		}
		//end vòng lặp xuất data
		
		//xuất html
		$css = '';
		if(isset($dataPages['css']) && $dataPages['css']!=''){
			$css = $dataPages['css'];
		}
		
		$javascript = '';
		if(isset($dataPages['javascript']) && $dataPages['javascript']!=''){
			$javascript = $dataPages['javascript'];
		}
		
		if(isset($dataPages['html']) && $dataPages['html']!=''){
			eval($dataPages['html']);
		}
		
		$html .= $css.$javascript;
		//end xuất html
		
		return $html;
	}
	
	public function pageAction($dataPages, $_id){
		//lay thong tin data trang hiện tại
		$collection = $dataPages['collection'];
		$filter = array(
			'where' => array('_id'=>$_id),
		);
		$dataCurrent = $this->model->findOne($collection, $filter);
		//end lay thong tin data trang hiện tại
		
		//include_once form
		include_once('controllers/form.php');
		$form = new form();
		
		//vòng lặp xuất data
		$php = '';
		if(isset($dataPages['php_admin'])){
			eval($dataPages['php_admin']);
		}
		//end vòng lặp xuất data
		
		//xuất html
		$css_admin = '';
		if(isset($dataPages['css_admin'])){
			$css_admin = $dataPages['css_admin'];
		}
		
		$javascript_admin = '';
		if(isset($dataPages['javascript_admin'])){
			$javascript_admin = $dataPages['javascript_admin'];
		}
		
		$html = '';
		if(isset($dataPages['html_admin'])){
			eval($dataPages['html_admin']);
		}
		//end xuất html
		
		return $html;
	}
}

$control = new admin();
if(isset($_SESSION['admin'])){
	$control = new admin();
	$pageCurrent = $control->pageCurrent();
	
	include_once('views/admin.php');
}else{
	include_once('views/admin_login.php');
}