<?php
class allPage{
    public $model;
	public $user;
    public $alias;
    public $page;
    public $pageInfo;
    public $collection;
    public $setting;
    
    public function __construct(){
		include_once('models/modelAllPage.php');
		$this->model = new modelAllPage;
    }
    
    public function getUsers(){
		if(!isset($_SESSION['users'])){
			$_SESSION['guest'] = array(
				'name' => 'Guest',
				'username' => 'guest',
				'groups' => 'everyone',
			);
			
			$this->user = $_SESSION['guest'];
		}else{
			$this->user = $_SESSION['users'];
		}
    }
	
	public function setting($lang=''){
		$filter = array(
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
				'where' => array('page'=>$this->page),
			);
		}else{
			$filter = array(
				'where' => array('alias'=>$this->alias),
			);
		}
		
		$dataCurrent = $this->model->findOne(_POSTS_, $filter);
		if(isset($dataCurrent['page'])){
			$this->page = $dataCurrent['page'];
		}
		
		$this->pageInfo = $dataCurrent;
		
		$html = $this->pageHTML();
		
		return $html;
	}
	
	private function pageHTML(){
		$filter = array(
			'where' => array('type'=>'web', 'status'=>'1', 'name'=>$this->page),
		);
		$dataPages = $this->model->findOne(_PAGES_, $filter);
		
		//xuất widgets
		if(isset($dataPages['widgets'])){
			$strWidget = '';
			foreach($dataPages['widgets'] as $widget=>$label){
				$strWidget .= '$'.$widget.' = $this->widgets("'.$widget.'");';
			}
			eval($strWidget);
		}
		//end xuất widgets
		
		//vòng lặp xuất data
		if(isset($dataPages['php'])){
			eval($dataPages['php']);
		}
		//end vòng lặp xuất data
		
		//xuất html
		$css = '';
		if(isset($dataPages['css']) && $dataPages['css']!=''){
			$css = '<style type="text/css">'.$dataPages['css'].'</style>';
		}
		
		$javascript = '';
		if(isset($dataPages['javascript'])){
			$javascript = $dataPages['javascript'];
		}
		
		$html = '';
		if(isset($dataPages['html'])){
			eval($dataPages['html']);
		}
		//end xuất html
		
		return $html;
	}
	
	public function widgets($name){
		$filter = array(
			'where' => array('status'=>'1', 'name'=>$name),
		);
		$dataCollection = $this->model->findOne(_WIDGETS_, $filter);
		
		//lấy collection
		$dataCurrent = array();
		if(isset($dataCollection['collection']) && $dataCollection['collection']!=''){
			$collection = $dataCollection['collection'];
			$filter = $this->model->_getCollectionFilter($dataCollection);
			$dataCurrent = $this->model->find($collection, $filter);
		}
		//end lấy collection
		
		//vòng lặp xuất data
		if(isset($dataCollection['php']) && $dataCollection['php']!=''){
			eval($dataCollection['php']);
		}
		//end vòng lặp xuất data
		
		//xuất html
		$css = '';
		if(isset($dataCollection['css']) && $dataCollection['css']!=''){
			$css = '<style type="text/css">'.$dataCollection['css'].'</style>';
		}
		
		$javascript = '';
		if(isset($dataCollection['javascript'])){
			$javascript = $dataCollection['javascript'];
		}
		
		$html = '';
		if(isset($dataCollection['html'])){
			eval($dataCollection['html']);
		}
		//end xuất html
		
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

$control->getUsers();
$control->setting();

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