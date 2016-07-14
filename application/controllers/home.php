<?php
include_once('models/modelAllPage.php');
class home{
	private $model;
    private $page;
    
    public function __construct(){
		$this->model = new modelAllPage;
		
        $this->handle();
    }
	
	private function handle(){
		include_once('views/web.php');
	}
}
?>