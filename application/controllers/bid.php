<?php
class bid{
	private $model;
	private $document;
	private $product;
	
	public function handle($model, $document){
		$this->model = $model;
		$this->document = $document;
		
		//get product
		if(isset($this->document['_id'])){
			if(!is_array($this->document['_id'])){
				$this->getProduct( $this->document['_id'] );
				if($this->product==false){
					return array('result'=>false, 'message'=>'ERROR: Không tìm thấy ID '.$this->document['_id']);
				}
				
				$result = $this->actionBID();
				$result['_id'] = $this->document['_id'];
			}else{
				if(isset($this->document['bid'])){
					return array('result'=>false, 'message'=>'ERROR: BID.');
				}
				
				$result = array();
				foreach($this->document['_id'] as $_id){
					$this->getProduct($_id);
					if($this->product==false){
						$result[] = array('result'=>false, 'message'=>'ERROR: Không tìm thấy ID '.$_id);
					}
					
					$r = $this->actionBID();
					$r['_id'] = $_id;
					
					$result[] = $r;
				}
			}
			
			$data = $this->dataBidNew();
			if(count($data) > 0){
				$result['data'] = $data;
			}
			
			return $result;
		}else{
			return array('result'=>false, 'message'=>'ERROR: _ID?');
		}
	}
	
	private function dataBidNew(){
		$data = array();
		$filter = array(
			'where' => array(
				'status' => true,
				'page' => 'product',
				'properties' => 'articles',
				'date_bid' => $this->model->_dateObject(time()),
			),
			'pretty' => array('name'=>1, 'img'=>1, 'price_cost'=>1, 'price_start'=>1, 'price_step'=>1, 'price_current'=>1, 'count_bid'=>1),
			'limit' => 3,
		);
		$dataProductNext = $this->model->find(_POSTS_, $filter);
		foreach($dataProductNext as $id=>$row){
			$price_cost = '&nbsp;';
			$sale_off = '&nbsp;';
			if($row['price_cost']!=0){
				$price_cost = $this->model->_number($row['price_cost']).' Đ';
				$sale_off = 100 - ($row['price_start']/$row['price_cost']*100);
				$sale_off = (int)$sale_off.'% OFF';
			}
			if(isset($row['count_bid'])){
				$count_bid = (int)$row['count_bid'];
			}else{
				$count_bid = 0;
			}
			
			$data[$id] = '<p class="img imgWidth"><img src="'._URL_THUMB_.$row['img'].'" alt="'.$row['name'].'" /></p>
			<p class="action-bid gray" type="register">Khởi điểm: '.$this->model->_number($row['price_start']).'</p>
			<p class="time-bid"><span></span></p>
			<div class="info-bid">
				<p class="count-bid">'.$count_bid.' BIDS</p>
				<p class="price-cost">'.$price_cost.'</p>
				<p class="sale-off">'.$sale_off.'</p>
				<p class="clear1">&nbsp;</p>
			</div>';
		}
		
		return $data;
	}
	
	private function actionBID(){
		//check date BID
		$dateCurrent = time();
		if(isset($this->product['date_bid'])){
			$date_bid = $this->product['date_bid']->sec;
			
			//$dateCurrent = 1468050010;
			//$date_bid    = 1469178560;
			
			if($dateCurrent >= $date_bid){
				if($dateCurrent < $date_bid+10){
					$time = $date_bid + 10 - $dateCurrent;
					$result = $this->nextBID($time);
				}else if($dateCurrent <= $date_bid+40){
					$time = ($date_bid + 40 - $dateCurrent);
					$result = $this->startBID($time, (string)$this->product['_id']);
				}else if($dateCurrent <= $date_bid+50){
					$time = ($date_bid + 50 - $dateCurrent);
					$result = $this->endBID($time, (string)$this->product['_id']);
				}else{
					$result = array('result'=>true, 'message'=>'Hết giờ BID');
				}
				
				return $result;
			}else{
				//return array('result'=>false, 'message'=>'ERROR: Sản phẩm chưa đến giờ đấu.');
				return array('result'=>true, 'message'=>date(_DATETIME_, $this->product['date_bid']->sec), 'status'=>'future');
			}
		}else{
			return array('result'=>false, 'message'=>'ERROR: Sản phẩm không lên sàn.');
		}
	}
	
	private function getProduct($_id){
		$filter = array(
			'where' => array('_id'=>$_id),
			'pretty' => array(
				'price_cost'=>1,
				'price_start'=>1,
				'price_step'=>1,
				'price_current'=>1,
				'count_bid'=>1,
				'date_bid'=>1
			),
		);
		$data = $this->model->findOne(_POSTS_, $filter);
		
		if($data){
			$this->product = $data;
		}else{
			$this->product = false;
		}
	}
	
	private function nextBID($time){
		$message = 'Khởi điểm: '.$this->model->_number($this->product['price_start']).' đ';
		return array('result'=>true, 'message'=>$message, 'status'=>'wait', 'time'=>$time);
	}
	
	private function startBID($time, $id){
		$count = 0;
		$type = 'login';
		if(isset($this->product['price_current']) && $this->product['price_current']!=0){
			$price_current = $this->product['price_current'];
		}else{
			$price_current = $this->product['price_start'];
		}
		$message = 'BID: '.$this->model->_number($price_current).' đ';
		if(isset($this->product['count_bid'])){
			$count = $this->product['count_bid'];
		}
		
		$user = $this->model->_getUser();
		if(isset($user['groups']) && $user['groups']!=''){
			$type = 'bid';
			if(isset($this->document['bid'])){
				$date_bid = $this->product['date_bid'];
				$filter = array(
					'where' => array('product'=>$id, 'date_bid'=>array('$gte'=>$date_bid)),
					'sort' => array('_id'=>-1),
					'limit' => 1,
				);
				$data = $this->model->find('user_bid', $filter);
				if($data){
					$row = end($data);
					if(isset($row['user']['_id']) && $row['user']['_id']==(string)$user['_id']){
						$message = '<span style="text-transform:none; font-weight:100;">Bạn ra giá cao nhất '.$this->model->_number($row['price']).'đ</span>';
						return array('result'=>true, 'message'=>$message, 'status'=>'bid', 'time'=>$time, 'count'=>$count, 'type'=>'disable');
					}
				}
				
				$count++;
				if($this->product['price_current']!=0){
					$price_current = $this->product['price_current'] + $this->product['price_step'];
				}else{
					$price_current = $this->product['price_start'] + $this->product['price_step'];
				}
				$date_bid = $this->model->_dateObject(time()-10);
				$document = array(
					'_removeDataEmpty' => true,
					'price_current' => $price_current,
					'date_bid' => $date_bid,
					'count_bid' => $count,
				);
				$filter = array(
					'_id' => (string)$this->product['_id'],
				);
				$update = $this->model->update(_POSTS_, $document, $filter);
				
				$document = array(
					'product' => (string)$this->product['_id'],
					'price' => $price_current,
					'date_bid' => $this->model->_dateObject(),
					'user' => array(
						'_id' => (string)$user['_id'],
						'name' => $user['name'],
					),
				);
				$create = $this->model->create('user_bid', $document);
				
				$type = 'disable';
				$message = 'BID: '.$this->model->_number($price_current).' đ';
			}
		}
		
		return array('result'=>true, 'message'=>$message, 'status'=>'bid', 'time'=>$time, 'count'=>$count, 'type'=>$type);
	}
	
	private function endBID($time, $id){
		$count = 0;
		$date_bid = $this->product['date_bid'];
		$filter = array(
			'where' => array('product'=>$id, 'date_bid'=>array('$gte'=>$date_bid)),
			'sort' => array('_id'=>-1),
			'limit' => 1,
		);
		$data = $this->model->find('user_bid', $filter);
		if($data){
			$row = end($data);
			if(isset($this->product['count_bid'])) $count = $this->product['count_bid'];
			$message = 'Đã bán: '.$this->model->_number($row['price']).' đ';
			$winner = 'Chúc mừng<b>'.ucfirst($row['user']['name']).'</b>đã dành chiến thắng';
		}else{
			$message = 'Không người BID';
			$winner = '';
		}
		
		return array('result'=>true, 'message'=>$message, 'status'=>'end', 'time'=>$time, 'count'=>$count, 'winner'=>$winner);
	}
}