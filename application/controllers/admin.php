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
		
		if(isset($_SESSION['admin'])){
			$this->user = $_SESSION['admin'];
		}
		
		$this->getPage();
    }
	
	private function getPage(){
		global $currentUrl;
		$this->page = '';
		if(isset($currentUrl['other'])){
			$this->page = $currentUrl['other'][0];
			$_SESSION['admin']['pageCurrent'] = $this->page;
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
			if( (is_array($this->user['groups']) && in_array('administrators', $this->user['groups'])) || $this->user['groups']=='administrators' ){
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
			}else{
				$html = '<p>ERROR: Trang không tồn tại</p>';
			}
		}
		
		return $html;
	}
	
	private function pageView($dataPages){
		//lay thong tin data trang hiện tại
		$filter = $this->model->_getCollectionFilter($dataPages);
		$dataCurrent = $this->model->find($this->collection, $filter);
		//end lay thong tin data trang hiện tại
		
		//vòng lặp xuất data
		if(isset($dataPages['php']) && $dataPages['php']!=''){
			eval($dataPages['php']);
		}
		
		//xuất css
		$css = '';
		if(isset($dataPages['css']) && $dataPages['css']!=''){
			$css = $dataPages['css'];
		}
		
		//xuất script
		$script = '';
		if(isset($dataPages['javascript']) && $dataPages['javascript']!=''){
			$script = $dataPages['javascript'];
		}
		
		//xuất html
		$html = '';
		if(isset($dataPages['html']) && $dataPages['html']!=''){
			eval($dataPages['html']);
		}
		
		//xuất content
		$strRow = '';
		$pretty = $dataPages['pretty'];
		if($dataCurrent){
			foreach($dataCurrent as $key=>$row){
				if(isset($row['status']) && $row['status']==true){
					$status = '<a href="javascript:;" class="status status1 corner5"></a>';
				}else if(isset($row['status']) && $row['status']==false){
					$status = '<a href="javascript:;" class="status status0 corner5"></a>';
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
		
		$search = '';
		if(isset($dataPages['search']) && $dataPages['search']!=''){
			include_once('form_search.php');
			$frmSeach = new formSearch();
			$search = $frmSeach->view($this->model, $dataPages);
		}
		
		$html .= '<p class="btnCreate"><a href="cp_admin/'.$this->page.'/?_id=0" class="btnSmall bgBlue corner5">Add new</a></p>
		'.$search.'
		<p class="clear10"></p>
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
		
		//page list
		$pageList = $this->pageList($this->collection, $filter['where'], $filter['limit']);
		
		$html .= $pageList.$css.$script;
		return $html;
	}
	
	private function pageAction($dataPages, $_id){
		//lay thong tin data trang hiện tại
		$dataCurrent = array();
		if($_id != 0){
			$filter = array(
				'where' => array('_id'=>$_id),
			);
			$dataCurrent = $this->model->findOne($this->collection, $filter);
			if(!$dataCurrent){
				return '<p class="error">ERROR: Không tìm thấy dữ liệu</p>';
			}
		}
		//end lay thong tin data trang hiện tại
		
		//vòng lặp xuất data
		if(isset($dataPages['php_admin']) && $dataPages['php_admin']!=''){
			eval($dataPages['php_admin']);
		}
		//end vòng lặp xuất data
		
		//include_once form
		include_once('controllers/form.php');
		$form = new form();
		
		//xuất html
		$css = '';
		if(isset($dataPages['css_admin']) && $dataPages['css_admin']!=''){
			$css = $dataPages['css_admin'];
		}
		
		$javascript = '';
		if(isset($dataPages['javascript_admin']) && $dataPages['javascript_admin']!=''){
			$javascript = $dataPages['javascript_admin'];
		}
		
		$html = '';
		if(isset($dataPages['html_admin']) && $dataPages['html_admin']!=''){
			eval($dataPages['html_admin']);
		}else{
			$html = $form->view($this->model, $dataPages, $this->action, $dataCurrent);
		}
		$html .= $css.$javascript;
		//end xuất html
		
		//view form upload
		if(isset($dataPages['upload']) && $dataPages['upload']==true){
			$upload = ob_start();
			include_once("views/form_upload.php");
			$upload = ob_get_clean();
			$html .= $upload;
		}
		
		return $html;
	}
	
	public function pageList($collection, $where, $limit){
		$total = $this->model->findCount($collection, $where);
		$total = ceil($total / $limit);
		
		$str = '';
		if($total > 1){
			$url = $_SERVER['REQUEST_URI'];
			
			if(!isset($_GET['number'])){
				$page = 1;
				if(count($_GET)==0){
					$url .= '/?number=1';
				}else{
					$url .= '&number=1';
				}
			}else{
				$page = $_GET['number'];
				settype($page, 'int');
				if($page <= 0){
					$page = 1;
				}
			}
			
			if($total <= 5){
				for($start=1; $start<=$total; $start++){
					if($start != $page){
						$url = preg_replace('/number=[0-9]*[0-9]/is', 'number='.$start, $url);
						$str .= '<a href="'.$url.'">'.$start.'</a>';
					}else{
						$str .= '<span class="current">'.$start.'</span>';
					}
				}
			}else{
				//first page
				if($page > 3){
					$url = preg_replace('/number=[0-9]*[0-9]/is', 'number=1', $url);
					$str .= '<a href="'.$url.'">&laquo;</a>';
				}
				
				//before
				if($page > 1){
					$url = preg_replace('/number=[0-9]*[0-9]/is', 'number='.($page-1), $url);
					$str .= '<a href="'.$url.'">&lsaquo;</a><span class="space"></span>';
				}
				
				$start = $page-2;
				if($start < 1){
					$start = 1;
				}
				
				$end = $page+2;
				if($end > $total){
					$end = $total;
				}
				
				for($start; $start<=$end; $start++){
					if($start != $page){
						$url = preg_replace('/number=[0-9]*[0-9]/is', 'number='.$start, $url);
						$str .= '<a href="'.$url.'">'.$start.'</a>';
					}else{
						$str .= '<span class="current">'.$start.'</span>';
					}
				}
				
				//after
				if($page < $total){
					$url = preg_replace('/number=[0-9]*[0-9]/is', 'number='.($page+1), $url);
					$str .= '<span class="space"></span><a href="'.$url.'">&rsaquo;</a>';
				}
				
				//last page
				if($page+2 < $total){
					$url = preg_replace('/number=[0-9]*[0-9]/is', 'number='.$total, $url);
					$str .= '<a href="'.$url.'">&raquo;</a>';
				}
			}
			$str = '<div class="page-list">'.$str.'</div>';
		}
		
		return $str;
	}
}

if(isset($_SESSION['admin'])){
	$control = new admin();
	$pageCurrent = $control->pageCurrent();
	
	include_once('views/admin.php');
}else{
	include_once('views/admin_login.php');
}