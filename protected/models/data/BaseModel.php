<?php
class BaseModel extends CActiveRecord {
	
	//AR查询通用方法 排序
	public function order($order_way = 'id DESC') {
		$this->getDbCriteria ()->mergeWith ( array (
				'order' => $order_way, 
		    )
		);
		return $this;
	}
	
	//AR查询通用方法 取几条
	public function top($limit=5) {
		$this->getDbCriteria ()->mergeWith ( array (
				'limit' => $limit,
		    )
		);
		return $this;
	}
}

?>