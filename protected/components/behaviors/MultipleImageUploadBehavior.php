<?php
class MultipleImageUploadBehavior extends CActiveRecordBehavior{
	
	public $attribute_img;
	
	public $attribute_alt;
	
	public function afterFind($event){
		if(!empty(Yii::app()->controller->module->id)&&Yii::app()->controller->module->id=='admin'){
			$cond=isset($this->owner->model_id)&&!empty($this->owner->model_id)?array('gallery_id'=>$this->owner->id,'model_id'=>$this->owner->model_id):array('gallery_id'=>$this->owner->id,'model_id'=>get_class($this->owner));
			$gallery_imgs=GalleryImg::model()->findAllByAttributes($cond);
			$img_array=array();
			$alt_array=array();
			foreach ($gallery_imgs as $k=>$v){
				$img_array[$k]=$v->img_url;
				$alt_array[$k]=$v->alt;
			}	
			$attribute_img=$this->attribute_img;
			$attribute_alt=$this->attribute_alt;
			$this->owner->$attribute_img=implode('#|#', $img_array);
			$this->owner->$attribute_alt=implode('#|#', $alt_array);
		}
	}
	
	public function afterDelete($event){
		$cond=isset($this->owner->model_id)&&!empty($this->owner->model_id)?array('gallery_id'=>$this->owner->id,'model_id'=>$this->owner->model_id):array('gallery_id'=>$this->owner->id,'model_id'=>get_class($this->owner));
		$gallery_imgs=GalleryImg::model()->findAllByAttributes($cond);
		foreach ($gallery_imgs as $v){
			$v->delete();
		}
		return parent::afterDelete($event);
	}
	
	public function beforeSave($event){
		$attribute_img=$this->attribute_img;
		$img_num=count(explode('#|#', $this->owner->$attribute_img));
		$this->owner->num=$img_num;
		return parent::beforeSave($event);
	}
	
	public function afterSave($event){
		if(!$this->owner->isNewRecord){
			$cond=isset($this->owner->model_id)&&!empty($this->owner->model_id)?array('gallery_id'=>$this->owner->id,'model_id'=>$this->owner->model_id):array('gallery_id'=>$this->owner->id,'model_id'=>get_class($this->owner));
			$gallery_imgs=GalleryImg::model()->findAllByAttributes($cond);
			foreach ($gallery_imgs as $v){
				$v->delete();
			}			
		}		
		$attribute_img=$this->attribute_img;
		$attribute_alt=$this->attribute_alt;
		$img_value=$this->owner->$attribute_img;
		$alt_value=$this->owner->$attribute_alt;
		if(!empty($img_value)){
			$img_array=explode('#|#', $img_value);
			$alt_array=explode('#|#', $alt_value);
			for ($i=0;$i<count($img_array);$i++){
				$gallery_img=new GalleryImg();
				$gallery_img->gallery_id=$this->owner->id;
				$gallery_img->model_name=get_class($this->owner);
				if(isset($this->owner->model_id))$gallery_img->model_id=$this->owner->model_id;
				$gallery_img->img_url=$img_array[$i];
				$gallery_img->alt=$alt_array[$i];
				$gallery_img->save(false);
			}
		}
		return parent::afterSave($event);
	}	
}

?>