<?php
class allPage{
    public $model;
	public $user;
    public $setting;
    public $alias;
    public $page;
    public $pageInfo;
    public $collection;
    
    public function __construct(){
		include_once('models/modelAllPage.php');
		$this->model = new modelAllPage;
		
		$this->user = $this->model->_getUser();
    }
	
	public function setting($lang=''){
		$filter = array(
			'where' => array('status'=>true),
			'pretty' => array('_id'=>0, 'name'=>1, 'value'=>1),
		);
		$data = $this->model->find('setting', $filter);
		
		$setting = array();
		foreach($data as $row){
			$setting[$row['name']] = $row['value'];
		}
		
		$this->setting = $setting;
    }
	
	public function currentPage($alias){
		$this->alias = trim($alias);
		
		if($this->alias==''){
			$this->page = 'home';
			$filter = array(
				'where' => array('page'=>'home'),
			);
		}else{
			$filter = array(
				'where' => array('alias'=>$this->alias),
			);
		}
		
		$pageInfo = $this->model->findOne(_POSTS_, $filter);
		if(isset($pageInfo['page'])){
			$this->page = $pageInfo['page'];
		}
		
		$this->pageInfo = $pageInfo;
		
		return $this->pageHTML();
	}
	
	private function pageHTML(){
		$filter = array(
			'where' => array('type'=>'web', 'status'=>true, 'name'=>$this->page),
		);
		$dataPages = $this->model->findOne(_PAGES_, $filter);
		
		$arrHTML	= array();
		$arrCSS		= array();
		$arrScript	= array();
		
		//xuất widgets
		if(isset($dataPages['widgets']) && $dataPages['widgets']!=''){
			foreach($dataPages['widgets'] as $widget=>$label){
				$strWidget = '$'.$widget.' = $this->widgets("'.$widget.'", $css, $script);';
				eval($strWidget);
				
				$arrCSS[] = $css;
				$arrScript[] = $script;
			}
		}
		
		//get dataCurrent
		$dataCurrent = array();
		if(isset($dataPages['collection']) && $dataPages['collection']!=''){
			$collection = $dataPages['collection'];
			
			$data = array();
			$array = array('pretty', 'where', 'sort', 'limit');
			foreach($array as $name){
				if(isset($dataPages[$name]) && $dataPages[$name]!=''){
					$data[$name] = $dataPages[$name];
				}
			}
			
			$filter = $this->model->_getCollectionFilter($data);
			$dataCurrent = $this->model->find($collection, $filter);
		}
		
		//vòng lặp xuất data
		if(isset($dataPages['php'])){
			eval($dataPages['php']);
		}
		
		//xuất css
		if(isset($dataPages['css']) && $dataPages['css']!=''){
			$arrCSS[] = '<style type="text/css">'.$dataPages['css'].'</style>';
		}
		$css = '';
		foreach($arrCSS as $row){
			$css .= $row;
		}
		
		//xuất script
		if(isset($dataPages['javascript']) && $dataPages['javascript']!=''){
			$arrScript[] = $dataPages['javascript'];
		}
		$script = '';
		foreach($arrScript as $row){
			$script .= $row;
		}
		
		//xuất html
		$html = '';
		if(isset($dataPages['html'])){
			eval($dataPages['html']);
		}
		
		$html .= $css.$script;
		
		return $html;
	}
	
	private function widgets($name, &$css, &$script){
		$filter = array(
			'where' => array('status'=>true, 'name'=>$name),
		);
		$dataWidgets = $this->model->findOne(_WIDGETS_, $filter);
		if(!$dataWidgets){
			return false;
		}
		
		//get dataCurrent
		$dataCurrent = array();
		if(isset($dataWidgets['collection']) && $dataWidgets['collection']!=''){
			$collection = $dataWidgets['collection'];
			
			$data = array();
			$array = array('pretty', 'where', 'sort', 'limit');
			foreach($array as $name){
				if(isset($dataWidgets[$name]) && $dataWidgets[$name]!=''){
					$data[$name] = $dataWidgets[$name];
				}
			}
			
			$filter = $this->model->_getCollectionFilter($data);
			$dataCurrent = $this->model->find($collection, $filter);
		}
		
		//vòng lặp xuất data
		if(isset($dataWidgets['php']) && $dataWidgets['php']!=''){
			eval($dataWidgets['php']);
		}
		
		//fields
		$fields = '';
		if(isset($dataWidgets['fields']) && isset($dataWidgets['action']) && $dataWidgets['fields']!='' && $dataWidgets['fields']!=''){
			include_once('form.php');
			$frm = new form();
			
			$action = $dataWidgets['action'];
			$fields = $frm->view($this->model, $dataWidgets, $action, $dataFields);
		}
		
		//xuất css
		if(isset($dataWidgets['css']) && $dataWidgets['css']!=''){
			$css = '<style type="text/css">'.$dataWidgets['css'].'</style>';
		}
		
		//xuất script
		if(isset($dataWidgets['javascript'])){
			$script = $dataWidgets['javascript'];
		}
		
		//xuất html
		$html = '';
		if(isset($dataWidgets['html'])){
			eval($dataWidgets['html']);
		}
		
		return $html;
	}
	
	public function head($data){
		$str = '';
		if(isset($data['title']) && $data['title']!=''){
			$title = strip_tags($data['title']);
			$str .= '<title>'.$title.'</title>';
		}else if(isset($data['name'])){
			$title = strip_tags($data['name']);
			$str .= '<title>'.$title.'</title>';
		}
		
		if(isset($data['description']) && $data['description']!=''){
			$description = strip_tags($data['description']);
			$description = $this->model->_removeSymbol($data['description']);
			$str .= '<meta name="description" content="'.$description.'" />';
		}
		
		if(isset($data['tags']) && $data['tags']!=''){
			$tags = strip_tags($data['tags']);
			$tags = $this->model->_removeSymbol($data['tags']);
			$str .= '<meta name="keywords" content="'.$tags.'" />';
		}
		
		$str .= '<meta name="robots" content="index,follow" />';
		return $str;
	}
}

$control = new allPage();

//get setting
$control->setting();

//get page
$alias = $currentUrl['alias'];
$html = $control->currentPage($alias);
echo $html;



/*$currentPage = $control->currentPage($file, $head);

$html = ob_start();
if(file_exists($file)){
	include_once($file);
}else{
	echo '<p class="error">ERROR: Không tồn tại trang này.</p>';
}
$html = ob_get_clean();

include_once('views/web.php');*/